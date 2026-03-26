<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Kerja;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\Penempatan;
use App\Models\Permintaan;
use App\Models\PermintaanDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermintaanKandidatController extends Controller
{
    public function index($permintaan)
    {
        $permintaan = Permintaan::findOrFail($permintaan);

        // Kita panggil: PermintaanDetail -> User -> Mahasiswa -> Kelas -> Jurusan
        $kandidat = PermintaanDetail::with([
            'mahasiswa.kelas.jurusan'
        ])
            ->where('permintaan_id', $permintaan->id)
            ->get();

        return view('layouts.admin.penempatan.detail.index', compact('permintaan', 'kandidat'));
    }

    public function create(Request $request, Permintaan $permintaan)
    {
        $mahasiswa = collect(); // default kosong

        // 1. Hitung Sisa Kuota
        // Kita hitung jumlah kandidat yang sudah terdaftar untuk permintaan ini
        $jumlahTerdaftar = $permintaan->details()->count();
        $sisaKuota = $permintaan->kuota - $jumlahTerdaftar;
        $sisaKuota = $sisaKuota < 0 ? 0 : $sisaKuota;

        // 2. Ambil daftar ID mahasiswa yang sudah terdaftar (agar bisa di-exclude)
        $terdaftarIds = $permintaan->details()->pluck('mahasiswa_id')->toArray();

        // hanya cari kalau tombol filter ditekan
        if ($request->has('filter')) {

            $query = Mahasiswa::with('kelas.jurusan')
                ->where('status_akademik', 'aktif')
                ->where('status_kerja', 'available')
                // Tambahkan ini: Jangan tampilkan mahasiswa yang sudah jadi kandidat di sini
                ->whereNotIn('id', $terdaftarIds);

            // jurusan
            if ($request->jurusan) {
                $query->whereHas('kelas', function ($q) use ($request) {
                    $q->where('jurusan_id', $request->jurusan);
                });
            }

            // ipk
            if ($request->ipk) {
                $query->where('ipk', '>=', $request->ipk);
            }

            // angkatan
            if ($request->angkatan) {
                $query->whereHas('kelas', function ($q) use ($request) {
                    $q->where('tahun_masuk', $request->angkatan);
                });
            }

            $mahasiswa = $query->orderBy('ipk', 'desc')->get();
        }

        $jurusan = Jurusan::get();

        $angkatan = Kelas::select('tahun_masuk')->distinct()->pluck('tahun_masuk');

        // Menarik data relasi perusahaan ke dalam objek $permintaan yang sudah ada
        $permintaan->load('perusahaan');

        return view('layouts.admin.penempatan.detail.create', compact(
            'permintaan',
            'mahasiswa',
            'jurusan',
            'angkatan',
            'sisaKuota'
        ));
    }

    public function store(Request $request, $id)
    {
        // 1. Cari data permintaan atau lempar 404 jika tidak ada
        $permintaan = Permintaan::findOrFail($id);

        // 2. Validasi input: pastikan ada mahasiswa yang dipilih
        if (!$request->has('mahasiswa') || empty($request->mahasiswa)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silakan pilih minimal satu mahasiswa.'
            ], 422);
        }

        // 3. Hitung total kandidat yang sudah ada + yang akan ditambah
        $jumlahBaru = count($request->mahasiswa);
        $jumlahLama = $permintaan->details()->count();
        $totalKandidat = $jumlahLama + $jumlahBaru;

        // 4. Proteksi sisi Server (Hard Limit)
        if ($totalKandidat > $permintaan->kuota) {
            $sisa = $permintaan->kuota - $jumlahLama;
            return response()->json([
                'status' => 'error',
                'message' => "Gagal. Kuota tersisa hanya untuk $sisa orang, Anda mencoba memasukkan $jumlahBaru orang."
            ], 422);
        }

        // 5. Proses simpan dengan Database Transaction agar aman
        DB::beginTransaction();
        try {
            foreach ($request->mahasiswa as $mahasiswaId) {
                // Cek apakah mahasiswa ini sudah pernah didaftarkan ke permintaan ini (menghindari duplikat)
                PermintaanDetail::firstOrCreate([
                    'permintaan_id' => $permintaan->id,
                    'mahasiswa_id' => $mahasiswaId,
                ], [
                    'status' => 'pending' // atau status awal lainnya
                ]);
                // Update status mahasiswa jadi on_process
                DB::table('mahasiswa')
                    ->where('id', $mahasiswaId)
                    ->update(['status_kerja' => 'on_process']);
            }

            // 🔥 UPDATE STATUS PERMINTAAN JADI PROSES
            if ($permintaan->status === 'open') {
                $permintaan->update([
                    'status' => 'proses'
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan kandidat ke dalam daftar.',
                'redirect' => route('admin.permintaan.kandidat.index', $permintaan->id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            // Pesan error manusiawi
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function proses($id)
    {
        $permintaan = Permintaan::with([
            'details.mahasiswa',
            'perusahaan'
        ])->findOrFail($id);

        // Ambil semua kandidat dari permintaan_detail
        $kandidat = $permintaan->details;

        if ($permintaan->status === 'selesai') {
            return back()->with('error', 'Permintaan sudah selesai.');
        }

        if ($permintaan->details()->count() == 0) {
            return back()->with('error', 'Belum ada kandidat untuk diproses.');
        }

        return view('layouts.admin.penempatan.detail.proses', compact('permintaan', 'kandidat'));
    }

    public function prosesStore(Request $request, $id)
    {

        $request->validate([
            'kandidat.*.status' => 'required|in:lolos,gagal',
            'kandidat.*.tanggal_mulai' => 'nullable|date',
            'kandidat.*.durasi' => 'nullable|integer|min:1',
            'kandidat.*.durasi_tipe' => 'nullable|in:bulan,tahun',
            'kandidat.*.alasan' => 'nullable|string',
            'kandidat.*.catatan' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {

            $permintaan = Permintaan::findOrFail($id);

            // 🚨 CEGAH PROSES ULANG
            if ($permintaan->status === 'selesai') {
                return back()->with('error', 'Permintaan sudah selesai diproses.');
            }

            foreach ($request->kandidat as $detailId => $data) {

                $detail = PermintaanDetail::with('mahasiswa')
                    ->findOrFail($detailId);

                $mahasiswa = $detail->mahasiswa;

                $isGagal = $data['status'] === 'gagal';

                $alasanDropdown = $data['alasan'] ?? null;
                $catatan = $data['catatan'] ?? null;


                // Untuk interview.keterangan
                $keteranganInterview = null;

                if ($isGagal) {
                    $keteranganInterview = $alasanDropdown === 'lainnya'
                        ? $catatan
                        : $alasanDropdown;
                }

                /*
                |--------------------------------------------------------------------------
                | 1️⃣ UPDATE PERMINTAAN DETAIL
                |--------------------------------------------------------------------------
                */
                $detail->update([
                    'status'        => $data['status'], // lolos / gagal
                    'updated_at'    => now()
                ]);

                /*
                |--------------------------------------------------------------------------
                | 1️⃣ INSERT KE INTERVIEWS (SEMUA)
                |--------------------------------------------------------------------------
                */
                Interview::create([
                    'permintaan_detail_id'  => $detail->id,
                    'mahasiswa_id'          => $detail->mahasiswa_id,
                    'perusahaan_id'         => $permintaan->perusahaan_id,
                    'posisi'                => $permintaan->posisi,
                    'tgl_interview'         => $permintaan->tgl_panggilan,
                    'metode'                => 'offline',
                    'hasil'                 => $data['status'],
                    'alasan_gagal'          => $isGagal ? $alasanDropdown : null,
                    'keterangan'            => $keteranganInterview,
                ]);

                /*
                |--------------------------------------------------------------------------
                | 2️⃣ JIKA LOLOS
                |--------------------------------------------------------------------------
                */
                if ($data['status'] === 'lolos') {

                    if (empty($data['tanggal_mulai'])) {
                        throw new \Exception('Tanggal mulai wajib diisi untuk kandidat yang lolos.');
                    }

                    $tanggalMulai = Carbon::parse($data['tanggal_mulai']);
                    $tanggalInterview = Carbon::parse($permintaan->tgl_panggilan);

                    if ($tanggalMulai->lt($tanggalInterview)) {
                        throw new \Exception('Tanggal mulai tidak boleh sebelum tanggal interview.');
                    }

                    $tanggalSelesai = null;
                    $tipeKontrak = null;

                    if ($permintaan->jenis === 'magang') {

                        $durasi = (int) $data['durasi'];

                        $tanggalSelesai = $data['durasi_tipe'] === 'bulan'
                            ? $tanggalMulai->copy()->addMonths($durasi)
                            : $tanggalMulai->copy()->addYears($durasi);
                    } elseif ($permintaan->jenis === 'kerja') {
                        $tipeKontrak = $data['tipe_kontrak'] ?? null;
                    }

                    Penempatan::create([
                        'permintaan_detail_id'  => $detail->id,
                        'mahasiswa_id'          => $detail->mahasiswa_id,
                        'perusahaan_id'         => $permintaan->perusahaan_id,
                        'jenis'                 => $permintaan->jenis, // magang / kerja
                        'posisi'                => $permintaan->posisi,
                        'tipe_kontrak'          => $tipeKontrak,
                        'tgl_mulai'             => $tanggalMulai,
                        'tgl_selesai'           => $tanggalSelesai,
                        'status'                => 'aktif',
                        'sumber'                => 'c&p'
                    ]);

                    $mahasiswa->update([
                        'status_kerja' => $permintaan->jenis // magang / kerja
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | 3️⃣ JIKA GAGAL
                |--------------------------------------------------------------------------
                */
                if ($data['status'] === 'gagal') {
                    $mahasiswa->update([
                        'status_kerja' => 'available'
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 5️⃣ UPDATE STATUS PERMINTAAN JADI SELESAI
            |--------------------------------------------------------------------------
            */
            $permintaan->update([
                'status' => 'selesai'
            ]);

            $permintaan->lock();

            DB::commit();

            return redirect()
                ->route('admin.permintaan.kandidat.index', $permintaan->id)
                ->with('success', 'Hasil seleksi berhasil diproses.');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($permintaanId, $detailId)
    {
        $permintaan = Permintaan::with('perusahaan')
            ->findOrFail($permintaanId);

        $detail = PermintaanDetail::with('mahasiswa.user')
            ->findOrFail($detailId);

        if ($permintaan->status === 'selesai') {
            abort(403, 'Permintaan sudah selesai.');
        }

        return view(
            'layouts.admin.penempatan.detail.edit',
            compact('permintaan', 'detail')
        );
    }


    public function update(Request $request, $permintaanId, $detailId)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id'
        ]);

        DB::transaction(function () use ($request, $detailId) {

            $detail = PermintaanDetail::findOrFail($detailId);

            $oldMahasiswaId = $detail->mahasiswa_id;
            $newMahasiswaId = $request->mahasiswa_id;

            // Kalau mahasiswa sama, tidak perlu apa-apa
            if ($oldMahasiswaId == $newMahasiswaId) {
                return;
            }

            // 1️⃣ Kembalikan status kandidat lama
            $oldMahasiswa = Mahasiswa::where('id', $oldMahasiswaId)->first();
            if ($oldMahasiswa) {
                $oldMahasiswa->update([
                    'status_kerja' => 'available'
                ]);
            }

            // 2️⃣ Update permintaan_detail ke kandidat baru
            $detail->update([
                'mahasiswa_id' => $newMahasiswaId
            ]);

            // 3️⃣ Ubah status kandidat baru
            $newMahasiswa = Mahasiswa::where('id', $newMahasiswaId)->first();
            if ($newMahasiswa) {
                $newMahasiswa->update([
                    'status_kerja' => 'on_process'
                ]);
            }
        });

        return redirect()
            ->route('admin.permintaan.kandidat.index', $permintaanId)
            ->with('success', 'Kandidat berhasil diperbarui.');
    }

    public function destroy($permintaanId, $kandidatId)
    {
        DB::transaction(function () use ($permintaanId, $kandidatId) {

            $kandidat = PermintaanDetail::where('id', $kandidatId)
                ->where('permintaan_id', $permintaanId)
                ->firstOrFail();

            // Update status mahasiswa berdasarkan user_id
            Mahasiswa::where('id', $kandidat->mahasiswa_id)
                ->update([
                    'status_kerja' => 'available'
                ]);

            // Hapus kandidat
            $kandidat->delete();
        });

        return back()->with('success', 'Kandidat berhasil dihapus dan status mahasiswa menjadi available.');
    }
}
