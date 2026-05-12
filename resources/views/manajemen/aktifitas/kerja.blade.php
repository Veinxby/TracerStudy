@extends('template.main')
@section('title', 'Riwayat Kerja | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Riwayat Kerja</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Kerja</div>
            </div>
        </div>
        <div class="section-body">

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if(session('import_success') || session('import_failed'))

                {{-- BERHASIL --}}
                @if(session('import_success') > 0)
                    <div class="alert alert-success alert-dismissible fade show">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        ✅ {{ session('import_success') }} data berhasil diimport.
                    </div>
                @endif


                {{-- GAGAL --}}
                @if(session('import_failed') > 0)
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>

                        ❌ {{ session('import_failed') }} data gagal diimport.

                        <div class="mt-2">
                            <a class="font-weight-bold"
                            data-toggle="collapse"
                            href="#collapseFailed">
                                ▶ Lihat detail
                            </a>
                        </div>

                        <div class="collapse mt-2" id="collapseFailed">
                            <div class="border-top pt-2" style="max-height:200px; overflow:auto;">
                                <ul class="mb-0 pl-3">
                                    @foreach(session('failed_list') as $fail)
                                        <li>
                                            {{ $fail['nipd'] }} - {{ $fail['nama'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                @endif

            @endif

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <div>
                    <h2 class="section-title">Daftar Riwayat Kerja</h2>
                    <p class="section-lead mb-0">Tabel hanya menampilkan 200 data riwayat kerja terakhir.</p>
                </div>
                <div class="text-right">
                    <div class="text-small font-weight-bold text-muted text-uppercase">
                        Total Data
                    </div>

                    <div style="font-size:35px; font-weight:700;">
                        {{ number_format($totalKerja) }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">Daftar Riwayat Kerja</h4>
                            </div>

                            <div>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>

                                <button class="btn btn-info" data-toggle="modal" data-target="#modalImport">
                                    <i class="fas fa-file-import"></i> Import
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="table-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Nama</th>
                                            <th>Perusahaan</th>
                                            <th>Posisi</th>
                                            <th>Tipe Kontrak</th>
                                            <th>tgl kerja</th>
                                            <th>Sumber</th>
                                            <th>Status</th>
                                            <th width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kerja as $k)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="font-weight-600">{{ $k->user->nama ?? '-' }}</td>
                                                <td>{{ $k->perusahaan->nama_perusahaan ?? '-' }}</td>
                                                <td>{{ $k->posisi ?? '-' }}</td>
                                                <td>{{ $k->tipe_kontrak ?? '-' }}</td>
                                                <td>{{ $k->tgl_mulai ?? '-' . $k->tgl_selesai ?? '-' }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $sumberColor = [
                                                            'c&p' => 'text-primary border-primary',
                                                            'mandiri' => 'text-info border-info'
                                                        ][$k->sumber] ?? 'text-secondary border-secondary';
                                                    @endphp
                                                    <span class="badge border {{ $sumberColor }} px-2 py-1" style="background: transparent;">
                                                        {{ strtoupper($k->sumber ?? '-') }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $statusColor = [
                                                            'aktif' => 'text-primary border-primary',
                                                            'selesai' => 'text-success border-success',
                                                        ][$k->status] ?? 'text-secondary border-secondary';
                                                    @endphp
                                                    <span class="badge border {{ $statusColor }} px-2 py-1" style="background: transparent;">
                                                        {{ ucfirst($k->status ?? '-') }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center" style="gap: 5px;">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-warning btn-edit" 
                                                                data-id="{{ $k->id }}"
                                                                data-user_id="{{ $k->user_id }}"
                                                                data-nama_mhs="{{ $k->user->nama }}"
                                                                data-perusahaan_id="{{ $k->perusahaan_id }}"
                                                                data-nama_perusahaan="{{ $k->perusahaan->nama_perusahaan }}"
                                                                data-tgl_mulai="{{ $k->tgl_mulai }}"
                                                                data-sumber="{{ $k->sumber }}"
                                                                data-status="{{ $k->status }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        
                                                        <button class="btn btn-sm btn-outline-danger btn-delete" 
                                                                data-id="{{ $k->id }}" 
                                                                title="Hapus Data">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Modal modal --}}
    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        Tambah Data Kerja
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <!-- Form -->
                <form id="formTambahKerja">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Mahasiswa</label>
                                <div class="d-flex">
                                    <div class="border rounded-left bg-light px-3 d-flex align-items-center">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <select name="user_id" id="user_id" class="form-control select2 rounded-0 rounded-right" required></select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Perusahaan</label>
                                <div class="d-flex">
                                    <div class="border rounded-left bg-light px-3 d-flex align-items-center">
                                        <i class="fas fa-building text-primary"></i>
                                    </div>
                                    <select name="perusahaan_id" id="perusahaan_id" class="form-control select2 rounded-0 rounded-right" required></select>
                                </div>
                            </div>
                        </div>

                        {{-- ================= POSISI & TIPE KONTRAK ================= --}}
                        <div class="form-row mt-3">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Posisi Kerja</label>
                                <div class="input-group shadow-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-briefcase text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="posisi" class="form-control"
                                        placeholder="Contoh: Backend Developer" required>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Tipe Kontrak</label>
                                <select name="tipe_kontrak" class="form-control" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="PKWT">PKWT</option>
                                    <option value="PKWTT">PKWTT</option>
                                    <option value="Freelance">Freelance</option>
                                    <option value="Kontrak Proyek">Kontrak Proyek</option>
                                </select>
                            </div>
                        </div>

                        {{-- ================= TANGGAL ================= --}}
                        <div class="form-row mt-2">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Tanggal Mulai</label>
                                <div class="input-group shadow-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-calendar-alt text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="tgl_mulai" class="form-control"
                                        required onclick="this.showPicker()">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">
                                    Tanggal Selesai
                                    <small class="text-muted">(Opsional)</small>
                                </label>
                                <div class="input-group shadow-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-flag-checkered text-success"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="tgl_selesai" class="form-control"
                                        onclick="this.showPicker()">
                                </div>
                                <small class="text-muted">
                                    Kosongkan jika masih aktif/belum selesai
                                </small>
                            </div>
                        </div>

                        {{-- ================= STATUS ================= --}}
                        <div class="form-group mt-2">
                            <label class="font-weight-bold">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                                <option value="resign">Resign</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary shadow">
                            <i class="fas fa-save mr-1"></i> Simpan Data Kerja
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#table-2").dataTable({
            "columnDefs": [
                { 
                    "sortable": false, 
                    "targets": [2, 3, 6, 7, 8] // Mematikan sorting hanya di kolom "Aksi"
                },
                {
                    "className": "dt-center", 
                    "targets": [0, 4, 5, 6, 7, 8] // Memusatkan konten via JS (opsional)
                }
            ],
            "order": [[0, "asc"]], // Urutkan berdasarkan nomor di awal
            "language": {
                "emptyTable": "Tidak ada data kerja tersedia"
            }
        });
        $('#import-file').on('change', function() {
            // Ambil nama file
            var fileName = $(this).val().split('\\').pop();
            // Set ke label
            $(this).next('.custom-file-label').html(fileName);
        });
        $('#collapseDuplicate').on('shown.bs.collapse', function () {
            $('.toggle-duplicate').text('▼ Sembunyikan daftar eror');
        });

        $('#collapseDuplicate').on('hidden.bs.collapse', function () {
            $('.toggle-duplicate').text('▶ Lihat daftar eror');
        });


        // Tambah Form Modal
        // Fungsi Helper untuk inisialisasi Select2 Mahasiswa
        function initSelect2Mahasiswa(elementId, parentModalId) {
            $(elementId).select2({
                width: '100%',
                placeholder: 'Ketik 3 huruf awal nama mahasiswa...',
                dropdownParent: $(parentModalId),
                minimumInputLength: 3,
                ajax: {
                    url: "{{ route('admin.mahasiswa.searchMhs') }}",
                    dataType: 'json',
                    delay: 500,
                    data: function(params) { return { q: params.term }; },
                    processResults: function(data) { return { results: data }; },
                    cache: true,
                },
                templateResult: formatMahasiswa,
                templateSelection: function (data) {
                    return data.nama || data.text;
                }
            });
        }

        // Fungsi Helper untuk inisialisasi Select2 Perusahaan
        function initSelect2Perusahaan(elementId, parentModalId) {
            $(elementId).select2({
                width: '100%',
                placeholder: 'Ketik 3 huruf awal nama perusahaan...',
                dropdownParent: $(parentModalId),
                minimumInputLength: 3,
                ajax: {
                    url: "{{ route('admin.perusahaan.search') }}",
                    dataType: 'json',
                    delay: 500,
                    data: function(params) { return { q: params.term }; },
                    processResults: function(data) { return { results: data }; },
                    cache: true,
                }
            });
        }

        // Fungsi format tampilan (tetap sama)
        function formatMahasiswa(data) {
            if (data.loading) return data.text;
            return $(
                "<div style='display: flex; justify-content: space-between; align-items: center; padding: 2px 0;'>" +
                    "<div>" +
                        "<div style='font-weight: bold; line-height: 1.2; color: inherit;'>" + data.nama + "</div>" +
                        "<div style='font-size: 0.8em; color: #d1d1d1; margin-top: 2px;'>" + data.kode_kelas + "</div>" +
                    "</div>" +
                    "<div>" +
                        "<span style='font-size: 0.8em; border: 1px solid #ddd; padding: 2px 8px; border-radius: 4px; background: rgba(255,255,255,0.1);'>" + data.tahun + "</span>" +
                    "</div>" +
                "</div>"
            );
        }

        $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        // Untuk Modal TAMBAH
        $('#modalTambah').on('shown.bs.modal', function () {
            initSelect2Mahasiswa('#user_id', '#modalTambah');
            initSelect2Perusahaan('#perusahaan_id', '#modalTambah');
        });

        // Untuk Modal EDIT
        $('#modalEdit').on('shown.bs.modal', function () {
            // Gunakan ID input yang ada di modal edit kamu (misal: #edit_user_id)
            initSelect2Mahasiswa('#edit_user_id', '#modalEdit');
            initSelect2Perusahaan('#edit_perusahaan_id', '#modalEdit');
        });

        // confirm modal tambah Kerja
        $('#formTambahKerja').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.kerja.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {

                     $('#modalTambah').modal('hide');

                    iziToast.success({
                        title: 'Berhasil',
                        message: res.message,
                        timeout: 1200,
                        position: 'topRight',
                        onClosing: function() {
                            location.reload();
                        }
                    });
                },
                error: function(xhr) {

                    let msg = 'Terjadi kesalahan';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    iziToast.error({
                        title: 'Gagal',
                        message: msg,
                        position: 'topRight'
                    });
                }
            });
        });
    </script>
@endsection