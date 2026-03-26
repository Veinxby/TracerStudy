@extends('template.main')
@section('title', 'Data Mahasiswa | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Mahasiswa</h1>
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
                                            <li>{{ $fail['nipd'] }} - {{ $fail['nama'] }} - {{ $fail['error'] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

            @endif



            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

                <div>
                    <h1 class="section-title">Data Mahasiswa</h1>
                    <div class="section-lead mb-0">
                        Informasi profil, jurusan, angkatan, dan status akademik mahasiswa
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.data-mhs.index') }}">
                    <div class="d-flex align-items-center">

                        <div class="mr-2">
                        <select name="jurusan" class="form-control form-control-sm" onchange="this.form.submit()">

                            <option value="">Semua Jurusan</option>

                            @foreach($jurusanList as $j)
                                <option value="{{ $j->kode_jurusan }}"
                                    {{ request('jurusan')==$j->kode_jurusan ? 'selected':'' }}>
                                    {{ $j->kode_jurusan }}
                                </option>
                            @endforeach

                        </select>
                    </div>


                    <div class="mr-2">
                        <select name="angkatan" class="form-control form-control-sm" onchange="this.form.submit()">

                            <option value="">Semua Angkatan</option>

                            @foreach($angkatanList as $a)
                                <option value="{{ $a }}"
                                    {{ request('angkatan')==$a ? 'selected':'' }}>
                                    {{ $a }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <a href="{{ route('admin.data-mhs.index') }}" 
                        class="btn btn-light btn-sm">
                        Reset
                    </a>

                    </div>
                </form>

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class=" card-header d-flex justify-content-between align-items-center mt-3 mx-3 flex-wrap">

                            {{-- LEFT --}}
                            <div class="pl-2">
                                <h4 class="mb-0 font-weight-bold">
                                    Data Mahasiswa
                                </h4>
                            </div>

                            {{-- RIGHT --}}
                            <div class="d-flex align-items-center flex-wrap pr-2 mt-3 mt-md-0">

                                @if(auth()->user()->role === 'adm_tracer')
                                    <span class="badge badge-light border mr-3 px-3 py-2 rounded-pill">
                                        <i class="fas fa-lock mr-1"></i> Mode Read Only
                                    </span>
                                @endif

                                @if(auth()->user()->hasPermission('mahasiswa.create'))
                                    <button class="btn btn-outline-primary rounded-pill px-3 mr-2"
                                            data-toggle="modal"
                                            data-target="#modalTambahMahasiswa">
                                        <i class="fas fa-plus mr-1"></i> Tambah
                                    </button>
                                @endif

                                @if(auth()->user()->hasPermission('mahasiswa.import'))
                                    <button class="btn btn-outline-info rounded-pill px-3 mr-2"
                                            data-toggle="modal"
                                            data-target="#modalImport">
                                        <i class="fas fa-file-import mr-1"></i> Import
                                    </button>
                                @endif

                                @if(auth()->user()->hasPermission('mahasiswa.export'))
                                    <button class="btn btn-outline-success rounded-pill px-3"
                                            data-toggle="modal"
                                            data-target="#modalExport">
                                        <i class="fas fa-file-export mr-1"></i> Export
                                    </button>
                                @endif

                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            {{-- <th class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th> --}}
                                            <th>NIPD</th>
                                            <th>Nama</th>
                                            <th>IPK</th>
                                            <th>Jurusan</th>
                                            <th>Angkatan</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mahasiswa as $m)
                                            <tr>
                                                <td>{{ $m->nipd }}</td>
                                                <td>{{ $m->user->nama ?? '-' }}</td>
                                                <td>{{ $m->ipk ? number_format($m->ipk, 2) : '-' }}</td>
                                                <td>{{ $m->kelas->jurusan->kode_jurusan . $m->kelas->kode_kelas  ?? '-' }}</td>
                                                <td>{{ $m->kelas->tahun_masuk ?? '-' }}</td>
                                                <td>
                                                    <div class="dropdown" >
                                                        <span class=" badge badge-pill
                                                        @if($m->status_akademik=='aktif') badge-success
                                                        @elseif($m->status_akademik=='cuti') badge-primary
                                                        @else badge-danger
                                                        @endif dropdown-toggle"
                                                        data-toggle="dropdown"
                                                        style="cursor:pointer"
                                                        data-id="{{ $m->id }}">
                                                        <i class="fas fa-circle mr-1" style="font-size:8px"></i>
                                                            {{ ucfirst($m->status_akademik) }}
                                                        </span>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item status-item"
                                                            data-status="aktif"
                                                            href="#">
                                                            <i class="fas fa-circle text-success mr-2"></i> Aktif
                                                            </a>

                                                            <a class="dropdown-item status-item"
                                                            data-status="cuti"
                                                            href="#">
                                                            <i class="fas fa-circle text-primary mr-2"></i> Cuti
                                                            </a>

                                                            <a class="dropdown-item status-item"
                                                            data-status="tidak aktif"
                                                            href="#">
                                                            <i class="fas fa-circle text-danger mr-2"></i> Tidak Aktif
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if(auth()->user()->hasPermission('mahasiswa.edit'))
                                                        <button class="btn btn-sm btn-outline-warning btn-edit"
                                                            data-id="{{ $m->id }}"
                                                            data-toggle="modal"
                                                            data-target="#modalEditMahasiswa">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    @endif
                                                    @if(auth()->user()->hasPermission('mahasiswa.view'))
                                                        <a href="{{ route('admin.mahasiswa.detail', $m->nipd) }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-info"></i>
                                                        </a>
                                                    @endif
                                                    @if(auth()->user()->hasPermission('mahasiswa.delete'))
                                                        <form action="{{ route('admin.data-mhs.destroy', $m->id) }}"
                                                            method="POST"
                                                            class="d-inline btn-hapus">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
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


    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEditMahasiswa" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="formEditMahasiswa">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Mahasiswa</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="edit_id">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>NIPD</label>
                                <input type="text" id="edit_nipd" class="form-control" disabled>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Nama Mahasiswa</label>
                                <input type="text" id="edit_nama" name="edit_nama" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="text" id="edit_email" name="edit_email" placeholder="Email@, boleh dikosongkan" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>No HP</label>
                                <input type="text" id="edit_no_hp" name="edit_no_hp" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Jenis Kelamin</label>
                                <select id="edit_jk" name="edit_k" class="form-control">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Jurusan</label>
                                <select id="edit_jurusan" name="kelas_id" class="form-control">
                                    <option value="">-- Pilih Kelas --</option>
                                    {{-- diisi via ajax --}}
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" id="edit_status" name="edit_status" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Domisili</label>
                            <input type="text" id="edit_domisili" name="edit_domisili" class="form-control">
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Export -->
    <div class="modal fade" id="modalExport" tabindex="-1" role="dialog" aria-labelledby="modalExportLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExportLabel">Export Data Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Klik tombol dibawah untuk export data mahasiswa ke Excel.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" data-dismiss="modal">Export</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="import-form" action="{{ route('admin.mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
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
                            <input type="file" class="custom-file-input" id="import-file" name="file" accept=".xlsx,.xls" required>
                            <label class="custom-file-label" for="import-file">Pilih file Excel</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                        <button class="btn btn-primary d-none" id="loadingBtn" disabled>
                            <span class="spinner-border spinner-border-sm"></span>
                            Mengimport data...
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <!-- Page Specific JS File -->
    <script src="../js/page/bootstrap-modal.js"></script>
    <script>
        $("#table-2").dataTable({
            "columnDefs": [
                { 
                    "sortable": false, 
                    "targets": [0, 3, 5, 6]
                },
                {
                    "className": "dt-center", 
                    "targets": [0, 4, 5, 6] 
                }
            ],
            "order": [[4, "desc"]],
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


        // Update Status Mahasiswa
        $(document).on('click', '.status-item', function (e) {
            e.preventDefault();

            let status = $(this).data('status');
            let badge = $(this).closest('td').find('.badge');
            let id = badge.data('id');

            $.ajax({
                url: `/adm/data-mhs/update-status/${id}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function () {
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Status akademik mahasiswa berhasil diperbarui',
                        position: 'topRight',
                        timeout: 1000,
                        onClosing: function () {
                            location.reload();
                        }
                    });
                },
                error: function (xhr) {
                    iziToast.error({
                        title: 'Gagal',
                        message: xhr.responseText,
                        position: 'topRight',
                        timeout: 2000,
                    });
                }
            });
        });


        // Edit Data Mahasiswa
        $(document).on('click', '.btn-edit', function () {
            let id = $(this).data('id');

            $.get(`/adm/data-mhs/${id}/edit`, function (res) {
                let m = res.mahasiswa;
                console.log(m.kelas.jurusan_id + m.kelas.kode_kelas);
                

                $('#edit_id').val(m.id);
                $('#edit_nipd').val(m.nipd);
                $('#edit_nama').val(m.user.nama);
                $('#edit_email').val(m.user.email ?? '');
                $('#edit_no_hp').val(m.no_hp);
                $('#edit_jk').val(m.jk);
                $('#edit_status').val(m.status_akademik);
                $('#edit_domisili').val(m.domisili);

                let opt = `<option value="">-- Pilih Kelas --</option>`;

                res.kelas.forEach(k => {
                    let label = `${k.jurusan_id}${k.kode_kelas} (${k.tahun_masuk})`;
                    let selected = m.kelas_id == k.id ? 'selected' : '';
                    opt += `<option value="${k.id}" ${selected}>${label}</option>`;
                });

                $('#edit_jurusan').html(opt);


                $('#modalEditMahasiswa').modal('show');
            });
        });


        $('#formEditMahasiswa').on('submit', function (e) {
            e.preventDefault();

            let id = $('#edit_id').val();

            $.ajax({
                url: `/adm/data-mhs/${id}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    nipd: $('#edit_nipd').val(),
                    nama: $('#edit_nama').val(),
                    email: $('#edit_email').val(),
                    no_hp: $('#edit_no_hp').val(),
                    jk: $('#edit_jk').val(),
                    kelas_id: $('#edit_jurusan').val(),
                    domisili: $('#edit_domisili').val(),
                },
                success: function (res) {
                    $('#modalEditMahasiswa').modal('hide');

                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Data mahasiswa berhasil diperbarui',
                        position: 'topRight',
                        timeout: 1500,
                        onClosing: function () {
                            location.reload();
                        }
                    });
                },
                error: function (xhr) {
                    let msg = 'Data mahasiswa gagal diperbarui';

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        msg = Object.values(errors)[0][0]; // ambil error pertama
                    }

                    iziToast.error({
                        title: 'Gagal',
                        message: msg,
                        position: 'topRight',
                        timeout: 2000,
                    });
                }
            });
        });

    </script>

@endsection