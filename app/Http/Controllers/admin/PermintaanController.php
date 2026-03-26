<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permintaan;
use App\Models\Perusahaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PermintaanController extends Controller
{
    public function index()
    {
        $totalPermintaan = Permintaan::count();
        $permintaan = Permintaan::with(['perusahaan', 'details'])
            ->withCount('details')
            ->orderBy('tgl_panggilan', 'desc')
            ->limit(500)
            ->get();

        return view('layouts.admin.penempatan.index', compact('permintaan', 'totalPermintaan'));
    }

    public function create()
    {
        return view('layouts.admin.penempatan.create');
    }

    public function generateKode(Request $request)
    {

        $now = Carbon::now('Asia/Jakarta');

        $tahun = $now->format('y');
        $bulan = $now->format('m');
        $jenis = $request->jenis;

        $prefixJenis = $jenis === 'magang' ? 'MG' : 'KR';

        $last = Permintaan::where('jenis', $jenis)
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->orderBy('id', 'desc')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->kode_permintaan, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $kode = 'PM-' . $prefixJenis . $tahun . $bulan . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return response()->json([
            'kode' => $kode
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'perusahaan_id' => 'required',
            'jenis' => 'required',
            'posisi' => 'required',
            'kuota' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $tahun = date('y');
            $bulan = date('m');

            $prefixJenis = $request->jenis === 'magang' ? 'MG' : 'KR';

            $last = Permintaan::where('jenis', $request->jenis)
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            if ($last) {
                $lastNumber = (int) substr($last->kode_permintaan, -4);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $kode = 'PM-' . $prefixJenis . $tahun . $bulan . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            Permintaan::create([
                'kode_permintaan' => $kode,
                'perusahaan_id' => $request->perusahaan_id,
                'jenis' => $request->jenis,
                'posisi' => $request->posisi,
                'kuota' => $request->kuota,
                'tgl_panggilan' => $request->tgl_panggilan,
                'catatan' => $request->catatan,
                'status' => 'open',
            ]);
        });

        return redirect()
            ->route('admin.permintaan.index')
            ->with('success', 'Permintaan berhasil dibuat');
    }

    public function edit($id)
    {
        // 1. Ambil data permintaan berdasarkan ID
        $p = Permintaan::findOrFail($id);
        if ($p->is_locked) {
            return redirect()->back()->with('error', 'Data sudah dikunci dan tidak bisa diedit.');
        }

        // 2. Ambil data perusahaan untuk dropdown (opsional, tergantung kebutuhan Select2 kamu)
        $perusahaan = Perusahaan::all();

        // 3. Arahkan ke view sesuai permintaan kamu
        return view('layouts.admin.penempatan.edit', compact('p', 'perusahaan'));
    }
    public function update(Request $request, $id)
    {
        $permintaan = Permintaan::withCount('details')->findOrFail($id);

        if ($permintaan->is_locked) {
            return redirect()->back()->with('error', 'Data sudah dikunci.');
        }

        $data = $request->validate([
            'perusahaan_id' => 'required',
            'jenis'         => 'required',
            'posisi'        => 'required',
            'kuota' => [
                'required',
                'integer',
                'min:' . $permintaan->details_count
            ],
            'tgl_panggilan' => 'required|date',
            'catatan'       => 'nullable',
        ], [
            'kuota.min' => 'Kuota tidak boleh kurang dari jumlah kandidat yang sudah ditambahkan (' . $permintaan->details_count . ')'
        ]);

        $permintaan->update($data);
        return redirect()->route('admin.permintaan.index')->with('success', 'Data berhasil diupdate');
    }

    // Hapus Data
    public function destroy($id)
    {
        $p = Permintaan::findOrFail($id);

        if ($p->is_locked) {
            return redirect()->back()->with('error', 'Data sudah dikunci dan tidak bisa dihapus.');
        }

        $p->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function unlock($id)
    {
        $p = Permintaan::findOrFail($id);

        $allowedRoles = ['it', 'adm_tracer'];

        if (!in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Anda tidak memiliki akses untuk unlock.');
        }

        $p->unlock();

        return back()->with('success', 'Data berhasil dibuka kembali.');
    }
}
