@extends('template.main')
@section('title', 'Riwayat Penempatan | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Riwayat Penempatan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Penempatan</div>
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

                {{-- ALERT SUKSES --}}
                @if(session('import_success') > 0)
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            {{ session('import_success') }} data berhasil diimport.
                        </div>
                    </div>
                @endif

                {{-- ALERT GAGAL + COLLAPSE --}}
                @if(session('import_failed') > 0)
                    <div class="alert alert-danger alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>

                            {{ session('import_failed') }} data gagal diimport.

                            <div class="mt-2">
                                <a class="text-white font-weight-bold toggle-duplicate"
                                data-toggle="collapse"
                                href="#collapseDuplicate"
                                role="button"
                                aria-expanded="false"
                                aria-controls="collapseDuplicate">
                                    ▶ Lihat daftar duplikasi
                                </a>
                            </div>

                            <div class="collapse mt-2" id="collapseDuplicate">
                                <div class="border-top pt-2">
                                    <ul class="mb-0 pl-3">
                                        @foreach(session('failed_list') as $fail)
                                            <li>{{ $fail['nipd'] }} - {{ $fail['nama'] }} - {{ session('error') }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

            @endif



            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <div>
                    <h2 class="section-title mt-0">Daftar Riwayat Penempatan</h2>
                    <p class="section-lead mb-0">Tabel data riwayat terakhir.</p>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="text-center px-3 border-right">
                        <small class="text-muted d-block font-weight-bold mb-1" style="font-size: 10px; letter-spacing: 0.8px;">TOTAL</small>
                        <span class="h5 mb-0 font-weight-bold text-primary" style="line-height: 1;">{{ $totalSemua }}</span>
                    </div>
                    
                    <div class="text-center px-3 border-right">
                        <small class="text-muted d-block font-weight-bold mb-1" style="font-size: 10px; letter-spacing: 0.8px;">AKTIF</small>
                        <span class="h5 mb-0 font-weight-bold text-success" style="line-height: 1;">{{ $totalAktif }}</span>
                    </div>
                    
                    <div class="text-center px-3">
                        <small class="text-muted d-block font-weight-bold mb-1" style="font-size: 10px; letter-spacing: 0.8px;">SELESAI</small>
                        <span class="h5 mb-0 font-weight-bold text-danger" style="line-height: 1;">{{ $totalSelesai }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap" style="gap: 15px;">
                        <div class="d-flex align-items-center" style="gap: 10px;">
                            
                            <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                <a href="{{ route('admin.penempatan.index') }}" 
                                class="btn btn-sm px-3 {{ !$jenis ? 'btn-primary' : 'btn-light border-right' }} font-weight-bold">Semua</a>
                                <a href="{{ route('admin.penempatan.index', ['jenis' => 'magang']) }}" 
                                class="btn btn-sm px-3 {{ $jenis === 'magang' ? 'btn-primary' : 'btn-light border-right' }} font-weight-bold">Magang</a>
                                <a href="{{ route('admin.penempatan.index', ['jenis' => 'kerja']) }}" 
                                class="btn btn-sm px-3 {{ $jenis === 'kerja' ? 'btn-primary' : 'btn-light' }} font-weight-bold">Kerja</a>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border shadow-sm dropdown-toggle px-3 font-weight-bold" type="button" data-toggle="dropdown" style="height: 31px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-filter text-muted" style="font-size: 11px;"></i>
                                    <span>{{ $status ? ucfirst($status) : 'Semua Status' }}</span>
                                </button>
                                <div class="dropdown-menu shadow-lg border-0 mt-2">
                                    <a class="dropdown-item small font-weight-bold" href="{{ route('admin.penempatan.index', ['jenis' => $jenis]) }}">Semua Status</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item small" href="{{ route('admin.penempatan.index', ['jenis' => $jenis, 'status' => 'aktif']) }}">
                                        <i class="fas fa-circle text-success mr-2" style="font-size: 8px;"></i> Aktif
                                    </a>
                                    <a class="dropdown-item small" href="{{ route('admin.penempatan.index', ['jenis' => $jenis, 'status' => 'selesai']) }}">
                                        <i class="fas fa-circle text-danger mr-2" style="font-size: 8px;"></i> Selesai
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center" style="gap: 8px;">
                            @if(auth()->user()->hasPermission('penempatan.create'))
                                <button class="btn btn-primary btn-sm px-3 shadow-sm font-weight-bold mr-2"
                                        data-toggle="modal"
                                        data-target="#modalTambah"
                                        style="height: 31px;">
                                    <i class="fas fa-plus mr-1"></i> Tambah Data
                                </button>
                            @endif

                            @if(auth()->user()->hasPermission('penempatan.import'))
                                <button class="btn btn-info btn-sm px-3 shadow-sm font-weight-bold text-white"
                                        data-toggle="modal"
                                        data-target="#modalImport"
                                        style="height: 31px;">
                                    <i class="fas fa-file-import mr-1"></i> Import
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-2">
                            <thead>
                                <tr>
                                    <th>Kode Permintaan</th>
                                    <th>Nama</th>
                                    <th>Perusahaan</th>
                                    <th>Posisi</th>
                                    <th>Jenis</th>
                                    <th>Periode</th>
                                    <th>Sumber</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penempatan as $p)
                                    <tr>
                                        <td>{{ $p->permintaanDetail->permintaan->kode_permintaan ?? '-' }}</td>
                                        <td>
                                            @if($p->user && $p->user->mahasiswa)
                                                <a href="{{ route('admin.mahasiswa.detail', $p->user->mahasiswa->nipd) }}"
                                                class="text-primary font-weight-bold">
                                                    {{ $p->user->nama }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $p->perusahaan->nama_perusahaan ?? '-' }}</td>
                                        <td>{{ $p->posisi ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-light border text-dark px-3 py-1">
                                                {{ strtoupper($p->jenis ?? '-') }}
                                            </span>
                                        </td>
                                        <td class="text-nowrap">
                                            @php
                                                $mulai = \Carbon\Carbon::parse($p->tgl_mulai);

                                                $selesai = $p->tgl_selesai 
                                                    ? \Carbon\Carbon::parse($p->tgl_selesai)
                                                    : null;

                                                $diff = $selesai ? $mulai->diff($selesai) : null;
                                            @endphp

                                            <div>
                                                <div class="font-weight-bold">
                                                    {{ $mulai->translatedFormat('d M Y') }}
                                                    <span class="text-muted">–</span>
                                                    {{ $selesai ? $selesai->translatedFormat('d M Y') : '???' }}
                                                </div>

                                                <div class="small text-muted">
                                                    @if($diff)
                                                        @if($diff->y > 0) {{ $diff->y }} th @endif
                                                        @if($diff->m > 0) {{ $diff->m }} bln @endif
                                                        @if($diff->d > 0) {{ $diff->d }} hr @endif
                                                    @else
                                                        Durasi tidak diketahui
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $sumberColor = [
                                                    'c&p' => 'text-primary border-primary',
                                                    'mandiri' => 'text-info border-info'
                                                ][$p->sumber] ?? 'text-secondary border-secondary';
                                            @endphp
                                            <span class="badge border {{ $sumberColor }} px-2 py-1" style="background: transparent;">
                                                {{ strtoupper($p->sumber ?? '-') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $statusColor = [
                                                    'aktif' => 'text-primary border-primary',
                                                    'selesai' => 'text-success border-success',
                                                    'lanjutan' => 'text-warning border-warning'
                                                ][$p->status] ?? 'text-secondary border-secondary';
                                            @endphp

                                            @if($p->status === 'aktif')
                                                @if(auth()->user()->hasPermission('penempatan.updateStatus'))
                                                    <div class="dropdown d-inline">
                                                        <span class="badge border {{ $statusColor }} px-3 py-1 dropdown-toggle shadow-sm"
                                                            style="cursor:pointer; background: transparent;"
                                                            data-toggle="dropdown">
                                                            {{ ucfirst($p->status) }}
                                                        </span>

                                                        <div class="dropdown-menu dropdown-menu-right 
                                                                    border border-secondary 
                                                                    shadow-sm 
                                                                    p-0 
                                                                    mt-2">

                                                            <button type="button"
                                                                    value="selesai"
                                                                    id="update-status"
                                                                    class="dropdown-item py-2 small d-flex justify-content-between align-items-center"
                                                                    data-id="{{ $p->id }}"
                                                                    data-status="selesai">
                                                                ✔ Tandai Selesai
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="badge border {{ $statusColor }} px-3 py-1">
                                                        {{ ucfirst($p->status) }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge border {{ $statusColor }} px-3 py-1">
                                                    {{ ucfirst($p->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $p->keterangan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div> {{-- Section Body--}}
    </section> {{-- Section--}}
    
    {{-- Modal modal --}}
    <!-- Modal Import -->
    <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="import-form" action="{{ route('admin.penempatan.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportLabel">Import Data Mahasiswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="import-file" name="file" accept=".xlsx,.xls,.csv" required>
                            <label class="custom-file-label" for="import-file">Pilih file Excel</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-info">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        Tambah Data Penempatan
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <!-- Form -->
                <form id="formTambah">
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

                        <div class="form-row mt-3">

                            <!-- Tanggal Mulai -->
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">
                                    Tanggal Mulai
                                </label>
                                <div class="input-group shadow-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-calendar-alt text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="tgl_mulai" id="tgl_mulai"
                                        class="form-control" required onclick="this.showPicker()">
                                </div>
                                <small class="text-muted">Langkah 1: Pilih tanggal mulai</small>
                            </div>

                            <!-- Tanggal Selesai -->
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Tanggal Selesai</label>
                                <div class="input-group shadow-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-flag-checkered text-success"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="tgl_selesai" id="tgl_selesai"
                                        class="form-control" required onclick="this.showPicker()">
                                </div>
                                <small class="text-muted">Langkah 3: Cek / sesuaikan tanggal</small>
                            </div>

                        </div>


                        <div class="form-row">

                            <!-- Durasi -->
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">
                                    Durasi
                                </label>
                                <div class="input-group shadow-sm">
                                    <input type="number"
                                        name="durasi"
                                        id="durasi_angka"
                                        class="form-control"
                                        placeholder="Contoh: 3"
                                        min="1"
                                        max="12">
                                    <div class="input-group-append">
                                        <select name="durasi_tipe"
                                                id="durasi_satuan"
                                                class="form-control"
                                                style="border-radius: 0 4px 4px 0; background-color: #f8f9fa;">
                                            <option value="bulan">Bulan</option>
                                            <option value="tahun">Tahun</option>
                                        </select>
                                    </div>
                                </div>
                                <small class="text-info font-italic">
                                    Langkah 2: Isi durasi untuk menghitung otomatis
                                </small>
                            </div>

                            <!-- Jenis -->
                            <div class="form-group col-md-8" id="jenisWrapper">
                                <label class="font-weight-bold">Jenis Penempatan</label>
                                <select name="jenis" id="jenis" class="form-control" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="magang">Magang</option>
                                    <option value="kerja">Kerja</option>
                                </select>
                            </div>

                            <!-- Tipe Kontrak (Kerja saja) -->
                            <div class="form-group col-md-4" id="tipeKontrakWrapper" style="display:none;">
                                <label class="font-weight-bold">Tipe Kontrak</label>
                                <select name="tipe_kontrak" class="form-control">
                                    <option value="">-- Pilih Tipe Kontrak --</option>
                                    <option value="tetap">Tetap</option>
                                    <option value="pkwt">PKWT</option>
                                    <option value="pkwtt">PKWTT</option>
                                    <option value="freelance">Freelance</option>
                                </select>
                                <small class="text-muted">Hanya untuk penempatan kerja</small>
                            </div>

                        </div>


                        <div class="form-row">

                            <!-- Posisi -->
                            <div class="form-group col-md-8">
                                <label class="font-weight-bold">Posisi</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-briefcase text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="text"
                                        name="posisi"
                                        class="form-control"
                                        placeholder="Contoh: Web Developer"
                                        required>
                                </div>
                            </div>

                            <!-- Sumber -->
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Sumber</label>
                                <select name="sumber" class="form-control" required>
                                    <option value="mandiri" selected>Mandiri</option>
                                    <option value="c&p">C&P</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-row">
                            <!-- Keterangan -->
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">Keterangan</label>
                                <input type="text" name="keterangan" class="form-control" placeholder="Catatan C&P">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary shadow">
                            <i class="fas fa-save mr-1"></i> Simpan Data Penempatan
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
                    "targets": [0, 2, 3, 5, 6]
                },
                {
                    "className": "dt-center", 
                    "targets": [0, 4, 5, 6] 
                }
            ],
            "order": [[4, "desc"]],
            "language": {
                "emptyTable": "Tidak ada data penempatan tersedia"
            }
        });
        $('#import-file').on('change', function() {
            // Ambil nama file
            var fileName = $(this).val().split('\\').pop();
            // Set ke label
            $(this).next('.custom-file-label').html(fileName);
        });

        $('#collapseDuplicate').on('shown.bs.collapse', function () {
            $('.toggle-duplicate').text('▼ Sembunyikan daftar duplikasi');
        });

        $('#collapseDuplicate').on('hidden.bs.collapse', function () {
            $('.toggle-duplicate').text('▶ Lihat daftar duplikasi');
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })


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

        $(document).ready(function() {
            function hitungOtomatis(prefix) {
                let tglMulaiVal = $(`#${prefix}tgl_mulai`).val();
                let durasi      = parseInt($(`#${prefix}durasi_angka`).val());
                let satuan      = $(`#${prefix}durasi_satuan`).val();

                if (tglMulaiVal && durasi > 0) {
                    let date = new Date(tglMulaiVal);
                    
                    if (satuan === 'bulan') {
                        date.setMonth(date.getMonth() + durasi);
                    } else {
                        date.setFullYear(date.getFullYear() + durasi);
                    }

                    let year  = date.getFullYear();
                    let month = ("0" + (date.getMonth() + 1)).slice(-2);
                    let day   = ("0" + date.getDate()).slice(-2);
                    
                    $(`#${prefix}tgl_selesai`).val(`${year}-${month}-${day}`);
                }
            }

            // Untuk Modal TAMBAH (tanpa prefix)
            $('#tgl_mulai, #durasi_angka, #durasi_satuan').on('input change', function() {
                hitungOtomatis(''); // Prefix kosong
            });

            // Untuk Modal EDIT (dengan prefix edit_)
            $('#edit_tgl_mulai, #edit_durasi_angka, #edit_durasi_satuan').on('input change', function() {
                hitungOtomatis('edit_'); // Prefix 'edit_'
            });

            $('#jenis').on('change', function () {

                if ($(this).val() === 'kerja') {

                    // Jenis kembali normal 4
                    $('#jenisWrapper')
                        .removeClass('col-md-8')
                        .addClass('col-md-4');

                    $('#tipeKontrakWrapper').show();
                } else {

                    // Jenis jadi 8 kolom
                    $('#jenisWrapper')
                        .removeClass('col-md-4')
                        .addClass('col-md-8');

                    $('#tipeKontrakWrapper').hide();
                }

            });
        });


        // Submit Tambah
        $('#formTambah').on('submit', function(e) {
            e.preventDefault();
            
            let formData = new Array();
            formData = $(this).serialize(); // Mengambil semua data form

            $.ajax({
                url: "{{ route('admin.penempatan.store') }}",
                type: "POST",
                data: formData,
                beforeSend: function() {
                    // Menonaktifkan tombol simpan agar tidak double click
                    $('button[type="submit"]').prop('disabled', true).addClass('btn-progress');
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Tutup modal & Reset form
                        $('#modalTambah').modal('hide');
                        $('#formTambah')[0].reset();
                        $('#user_id, #perusahaan_id').val(null).trigger('change'); // Reset Select2

                        // Notifikasi Sukses
                        iziToast.success({
                            title: 'Berhasil!',
                            message: response.message,
                            timeout: 1000,
                            position: 'topRight',
                            onClosing: function() {
                                location.reload();
                            }
                        });

                    }
                },
                error: function(xhr) {
                    $('button[type="submit"]').prop('disabled', false).removeClass('btn-progress');
                    
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        // Looping error validasi dari Laravel
                        $.each(errors, function(key, value) {
                            iziToast.error({
                                title: 'Error',
                                message: value[0],
                                position: 'topRight'
                            });
                        });
                    } else {
                        iziToast.error({
                            title: 'Gagal',
                            message: 'Terjadi kesalahan sistem.',
                            position: 'topRight'
                        });
                    }
                }
            });
        });


        // Update status
        $(document).on('click', '#update-status', function () {

            let id = $(this).data('id');
            let status = $(this).data('status');
            let badge = $(this).closest('td');

            $.ajax({
                url: '/adm/penempatan/' + id + '/update-status',
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function (response) {

                    iziToast.success({
                        title: 'Berhasil',
                        message: response.message,
                        timeout: 1000,
                        position: 'topRight',
                        onClosing: function() {
                            location.reload();
                        }
                    });

                },
                error: function (xhr) {

                    iziToast.error({
                        title: 'Gagal',
                        message: xhr.responseJSON.message,
                        position: 'topRight'
                    });
                }
            });

        });


    </script>
@endsection