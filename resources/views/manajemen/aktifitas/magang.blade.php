@extends('template.main')
@section('title', 'Riwayat Magang | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Riwayat Magang</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Magang</div>
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
                    <h2 class="section-title">Daftar Riwayat Magang</h2>
                    <p class="section-lead mb-0">Tabel hanya menampilkan 200 data riwayat magang terakhir.</p>
                </div>
                <div class="text-right">
                    <div class="text-small font-weight-bold text-muted text-uppercase">
                        Total Data
                    </div>

                    <div style="font-size:35px; font-weight:700;">
                        {{ number_format($totalMagang) }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">Daftar Riwayat Magang</h4>
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
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Sumber</th>
                                            <th>Status</th>
                                            <th width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($magang as $m)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="font-weight-600">{{ $m->user->nama ?? '-' }}</td>
                                                <td>{{ $m->perusahaan->nama_perusahaan ?? '-' }}</td>
                                                <td>{{ $m->posisi ?? '-' }}</td>
                                                <td>{{ $m->tgl_mulai ?? '-' }}</td>
                                                <td>{{ $m->tgl_selesai ?? '-' }}</td>
                                                
                                                <td class="text-center">
                                                    @php
                                                        $sumberColor = [
                                                            'c&p' => 'text-primary border-primary',
                                                            'mandiri' => 'text-info border-info'
                                                        ][$m->sumber] ?? 'text-secondary border-secondary';
                                                    @endphp
                                                    <span class="badge border {{ $sumberColor }} px-2 py-1" style="background: transparent;">
                                                        {{ strtoupper($m->sumber ?? '-') }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $statusColor = [
                                                            'berjalan' => 'text-primary border-primary',
                                                            'selesai' => 'text-success border-success',
                                                            'perpanjang' => 'text-warning border-warning'
                                                        ][$m->status] ?? 'text-secondary border-secondary';
                                                    @endphp
                                                    <span class="badge border {{ $statusColor }} px-2 py-1" style="background: transparent;">
                                                        {{ ucfirst($m->status ?? '-') }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center" style="gap: 5px;">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-warning btn-edit" 
                                                                data-id="{{ $m->id }}"
                                                                data-user_id="{{ $m->user_id }}"
                                                                data-nama_mhs="{{ $m->user->nama }}"
                                                                data-perusahaan_id="{{ $m->perusahaan_id }}"
                                                                data-nama_perusahaan="{{ $m->perusahaan->nama_perusahaan }}"
                                                                data-tgl_mulai="{{ $m->tgl_mulai }}"
                                                                data-tgl_selesai="{{ $m->tgl_selesai }}"
                                                                data-posisi="{{ $m->posisi }}"
                                                                data-metode="{{ $m->sumber }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        
                                                        <button class="btn btn-sm btn-outline-danger btn-delete" 
                                                                data-id="{{ $m->id }}" 
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
                        Tambah Data Magang
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
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">
                                Tanggal Mulai <i class="fas fa-info-circle text-muted" title="Tanggal awal mahasiswa magang"></i>
                            </label>
                            <div class="input-group shadow-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fas fa-calendar-alt text-primary"></i></span>
                                </div>
                                <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required onclick="this.showPicker()">
                            </div>
                            <small class="text-muted">Langkah 1: Pilih tanggal mulai</small>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">
                                Durasi <i class="fas fa-magic text-warning" title="Mengisi angka di sini akan menghitung tanggal selesai secara otomatis"></i>
                            </label>
                            <div class="input-group shadow-sm">
                                <input type="number" id="durasi_angka" class="form-control" placeholder="Contoh: 3" min="1">
                                <div class="input-group-append">
                                    <select id="durasi_satuan" class="form-control" style="border-radius: 0 4px 4px 0; background-color: #f8f9fa;">
                                        <option value="bulan">Bulan</option>
                                        <option value="tahun">Tahun</option>
                                    </select>
                                </div>
                            </div>
                            <small class="text-info font-italic">Langkah 2: Isi durasi (opsional)</small>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Tanggal Selesai</label>
                            <div class="input-group shadow-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fas fa-flag-checkered text-success"></i></span>
                                </div>
                                <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" required onclick="this.showPicker()">
                            </div>
                            <small class="text-muted">Langkah 3: Cek/sesuaikan tanggal</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label class="font-weight-bold">Posisi Magang</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light"><i class="fas fa-briefcase text-primary"></i></span>
                                </div>
                                <input type="text" name="posisi" class="form-control" placeholder="Contoh: Web Developer">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Sumber Lowongan</label>
                            <select name="metode" class="form-control">
                                <option value="mandiri">Mandiri</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow">
                        <i class="fas fa-save mr-1"></i> Simpan Data Magang
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title"><i class="fas fa-edit mr-2"></i> Edit Data Magang</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <form id="formEdit">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Mahasiswa</label>
                                <select name="user_id" id="edit_user_id" class="form-control select2" disabled></select>
                                <input type="hidden" name="user_id_hidden" id="edit_user_id_val">
                                <small class="text-danger">*Mahasiswa tidak dapat diubah</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Perusahaan</label>
                                <select name="perusahaan_id" id="edit_perusahaan_id" class="form-control select2" required></select>
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Tanggal Mulai</label>
                                <input type="date" name="tgl_mulai" id="edit_tgl_mulai" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Durasi Baru (Opsi)</label>
                                <div class="input-group">
                                    <input type="number" id="edit_durasi_angka" class="form-control" placeholder="0">
                                    <div class="input-group-append">
                                        <select id="edit_durasi_satuan" class="form-control">
                                            <option value="bulan">Bulan</option>
                                            <option value="tahun">Tahun</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Tanggal Selesai</label>
                                <input type="date" name="tgl_selesai" id="edit_tgl_selesai" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label class="font-weight-bold">Posisi Magang</label>
                                <input type="text" name="posisi" id="edit_posisi" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">Sumber Lowongan</label>
                                <select name="metode" id="edit_metode" class="form-control custom-select">
                                    <option value="c&p">C&P (Kampus)</option>
                                    <option value="mandiri">Mandiri</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-whitesmoke">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning shadow">
                            <i class="fas fa-sync mr-1"></i> Update Data Magang
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
                "emptyTable": "Tidak ada data magang tersedia"
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
        });



        // Submit Tambah
        $('#formTambah').on('submit', function(e) {
            e.preventDefault();
            
            let formData = new Array();
            formData = $(this).serialize(); // Mengambil semua data form

            $.ajax({
                url: "{{ route('admin.magang.store') }}",
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




        // Delete
        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            let row = $(this).closest('tr'); // Ambil baris tabelnya

            if (confirm('Yakin ingin menghapus data ini? Status mahasiswa akan kembali Available.')) {
                $.ajax({
                    url: "/adm/magang/" + id, // Sesuaikan dengan route destroy kamu
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            // Notifikasi sukses
                            iziToast.success({
                                title: 'Berhasil',
                                message: response.message,
                                position: 'topRight'
                            });

                            // Efek visual: Hapus baris dari tabel tanpa reload
                            row.fadeOut(500, function() {
                                $(this).remove();
                            });
                        }
                    },
                    error: function (xhr) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Terjadi kesalahan saat menghapus data.',
                            position: 'topRight'
                        });
                    }
                });
            }
        });








        // Edit button klik
        $(document).on('click', '.btn-edit', function() {
            // Ambil data dari atribut tombol
            const id        = $(this).data('id');
            const userId    = $(this).data('user_id');
            const namaMhs   = $(this).data('nama_mhs');
            const perushId  = $(this).data('perusahaan_id');
            const namaPerush = $(this).data('nama_perusahaan');
            const tglMulai  = $(this).data('tgl_mulai');
            const tglSelesai = $(this).data('tgl_selesai');
            const posisi    = $(this).data('posisi');
            const metode    = $(this).data('metode');

            // Isi form modal edit
            $('#edit_id').val(id);
            $('#edit_tgl_mulai').val(tglMulai);
            $('#edit_tgl_selesai').val(tglSelesai);
            $('#edit_posisi').val(posisi);
            $('#edit_metode').val(metode);

            // Handle Select2 Mahasiswa (Disabled/Readonly)
            // Kita paksa isinya karena Select2 AJAX tidak punya data awal
            let mhsOption = new Option(namaMhs, userId, true, true);
            $('#edit_user_id').append(mhsOption).trigger('change');
            $('#edit_user_id_val').val(userId); // Simpan di hidden input karena select disabled

            // Handle Select2 Perusahaan
            let perushOption = new Option(namaPerush, perushId, true, true);
            $('#edit_perusahaan_id').append(perushOption).trigger('change');

            // Reset durasi angka agar tidak membingungkan
            $('#edit_durasi_angka').val('');

            // Tampilkan Modal
            $('#modalEdit').modal('show');
        });


        // submit edit
        $('#formEdit').on('submit', function(e) {
            e.preventDefault();
            
            let id = $('#edit_id').val();
            let url = "{{ url('adm/magang') }}/" + id; // Sesuaikan prefix route
            let formData = $(this).serialize();

            $.ajax({
                url: url,
                type: "POST", // Laravel handle via _method PUT di form
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#modalEdit').modal('hide');
                        
                        iziToast.success({
                            title: 'Berhasil',
                            message: response.message,
                            position: 'topRight',
                            timeout: 1000,
                            onClosing: function() {
                                location.reload();
                            }
                        });
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Terjadi kesalahan sistem.';
                    if (xhr.status === 422) {
                        errorMsg = 'Mohon periksa kembali inputan Anda.';
                    }
                    
                    iziToast.error({
                        title: 'Error',
                        message: errorMsg,
                        position: 'topRight'
                    });
                }
            });
        });
    </script>
@endsection