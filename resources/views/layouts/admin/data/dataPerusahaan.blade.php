@extends('template.main')
@section('title', 'Rekanan Perusahaan | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Rekanan Perusahaan</h1>
        </div>
        <div class="section-body">

            {{-- @if(session('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('error') }}
                    </div>
                </div>
            @endif --}}

            {{-- JIKA ADA HASIL IMPORT --}}
            @if(session('import_success') || session('import_failed'))

                {{-- SUKSES --}}
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


                {{-- GAGAL --}}
                @if(session('import_failed') > 0)
                    <div class="alert alert-danger alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>

                            {{ session('import_failed') }} data gagal diimport.

                            {{-- tombol buka tutup --}}
                            <div class="mt-2">
                                <a class="text-white font-weight-bold"
                                data-toggle="collapse"
                                href="#collapseFailed"
                                role="button">
                                    ▶ Lihat detail error
                                </a>
                            </div>

                            {{-- isi error --}}
                            <div class="collapse mt-2" id="collapseFailed">
                                <div class="border-top pt-2">
                                    <ul class="mb-0 pl-3">
                                        @foreach(session('failed_list', []) as $fail)
                                            <li>
                                                {{ $fail['nama_perusahaan'] ?? '-' }} -
                                                {{ $fail['pesan'] ?? '-' }}
                                            </li>
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
                    <h2 class="section-title">Daftar Rekanan Perusahaan & Informasi Perusahaan</h2>
                    <p class="section-lead mb-0">
                        Tabel menampilkan data perusahaan, bidang, email, dan no hp.
                    </p>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3 flex-wrap">
                            <div>    
                                <div class="">
                                    <h4>Data Perusahaan</h4>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap mt-2 mt-md-0">

                                <button class="btn btn-sm btn-outline-primary mr-2 mb-2"
                                    data-toggle="modal" data-target="#modalTambahPerusahaan">
                                    <i class="fas fa-plus mr-1"></i> Tambah
                                </button>

                                <button class="btn btn-sm btn-outline-info mr-2 mb-2"
                                    data-toggle="modal" data-target="#modalImport">
                                    <i class="fas fa-file-import mr-1"></i> Import
                                </button>

                                <button class="btn btn-sm btn-outline-success mr-2 mb-2"
                                    data-toggle="modal" data-target="#modalExport">
                                    <i class="fas fa-file-export mr-1"></i> Export
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama PT</th>
                                            <th>Bidang</th>
                                            <th>Email</th>
                                            <th>No HP</th>
                                            <th>Alamat</th>
                                            <th>Status Mitra</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($perusahaan as $p)
                                            <tr>
                                                <td>{{ $p->id }}</td>
                                                <td>{{ $p->nama_perusahaan }}</td>
                                                <td>{{ $p->bidang_usaha ?? '-' }}</td>
                                                <td>{{ $p->email ?? '-' }}</td>
                                                <td>{{ $p->no_telepon ?? '-' }}</td>
                                                <td>{{ $p->alamat ?? '-' }}</td>
                                                <td>{{ $p->status_mitra ?? '-' }}</td>
                                                <td>
                                                    <button 
                                                        class="btn btn-sm btn-outline-warning btnEdit"
                                                        data-id="{{ $p->id }}"
                                                        data-nama="{{ $p->nama_perusahaan }}"
                                                        data-bidang="{{ $p->bidang_usaha }}"
                                                        data-email="{{ $p->email }}"
                                                        data-telepon="{{ $p->no_telepon }}"
                                                        data-alamat="{{ $p->alamat }}"
                                                        data-status="{{ $p->status_mitra }}">
                                                        <i class="fas fa-edit mr-1"></i>
                                                    </button>
                                                    <button 
                                                        class="btn btn-sm btn-outline-danger btnDelete"
                                                        data-id="{{ $p->id }}"
                                                        data-nama="{{ $p->nama_perusahaan }}">
                                                        <i class="fas fa-trash mr-1"></i>
                                                    </button>
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


    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambahPerusahaan" tabindex="-1">
        <div class="modal-dialog modal-lg">
            @if ($errors->tambahPerusahaan->any())
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('import_success') }} data berhasil diimport.
                    </div>
                </div>
            @endif
            <div class="modal-content">

                <form id="formTambahPerusahaan" autocomplete="off">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Perusahaan</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nama Perusahaan <span class="text-danger">*</span></label>
                            <small class="text-muted">(Wajib diisi dan tidak boleh duplikat)</small>
                            <input type="text" name="nama_perusahaan" class="form-control @error('nama_perusahaan', 'tambahPerusahaan') is-invalid @enderror"
                                value="{{ old('nama_perusahaan') }}" required autocomplete="new-password">
                                @error('nama_perusahaan', 'tambahPerusahaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Bidang Usaha</label>
                                <input type="text" name="bidang_usaha" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Status Mitra <span class="text-danger">*</span></label>
                                <select name="status_mitra" class="form-control">
                                    <option value="mitra">Mitra</option>
                                    <option value="non_mitra">Non Mitra</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" autocomplete="off">
                            </div>

                            <div class="form-group col-md-6">
                                <label>No Telepon</label>
                                <input type="text" name="no_telepon" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEditPerusahaan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEditPerusahaan">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-header">
                        <h5>Edit Perusahaan</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_perusahaan" id="edit_nama" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Bidang Usaha</label>
                            <input type="text" name="bidang_usaha" id="edit_bidang" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" name="no_telepon" id="edit_telepon" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" id="edit_alamat" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status Mitra <span class="text-danger">*</span></label>
                            <select name="status_mitra" id="edit_status" class="form-control">
                                <option value="mitra">Mitra</option>
                                <option value="non_mitra">Non Mitra</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
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
            <form id="import-form" action="{{ route('admin.data-perusahaan.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalImportLabel">Import Data Rekanan Perusahaan</h5>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#table-2").dataTable({
            "columnDefs": [
                { "sortable": false, "targets": [0,2,3] }
            ]
        });
        $('#import-file').on('change', function() {
            // Ambil nama file
            var fileName = $(this).val().split('\\').pop();
            // Set ke label
            $(this).next('.custom-file-label').html(fileName);
        });

        @if(request('open_modal') == 1)
            document.addEventListener("DOMContentLoaded", function() {

                $('#modalTambahPerusahaan').modal('show');

            });
        @endif

        // TAMBAH DATA
        $('#formTambahPerusahaan').submit(function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('admin.data-perusahaan.store') }}";

            $.ajax({
                url: url,
                method: "POST",
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {

                    $('#modalTambahPerusahaan').modal('hide');
                    form[0].reset();
                    
                    iziToast.success({
                        title: 'Berhasil',
                        message: response.message,
                        position: 'topRight',
                        timeout: 1000,
                        onClosing: function() {
                            location.reload();
                        }
                    });

                },
                error: function(xhr) {

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        let firstError = Object.values(errors)[0][0];

                        iziToast.error({
                            title: 'Validasi Gagal',
                            message: firstError,
                            position: 'topRight'
                        });
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'Terjadi kesalahan sistem.',
                            position: 'topRight'
                        });
                    }
                }
            });
        });


        // EDIT DATA
        $(document).on('click', '.btnEdit', function() {

            $('#edit_id').val($(this).data('id'));
            $('#edit_nama').val($(this).data('nama'));
            $('#edit_bidang').val($(this).data('bidang'));
            $('#edit_email').val($(this).data('email'));
            $('#edit_telepon').val($(this).data('telepon'));
            $('#edit_alamat').val($(this).data('alamat'));
            $('#edit_status').val($(this).data('status'));

            $('#modalEditPerusahaan').modal('show');
        });

        // SUBMIT UPDATE
        $('#formEditPerusahaan').submit(function(e) {
            e.preventDefault();

            let id = $('#edit_id').val();

            $.ajax({
                url: "{{ url('adm/data-perusahaan') }}/" + id,
                method: "POST",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {

                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Data berhasil diperbarui',
                        timeout: 1000,
                        position: 'topRight',
                        onClosing: function() {
                            location.reload();
                        }
                    });

                    $('#modalEditPerusahaan').modal('hide');
                    location.reload();
                },
                error: function() {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal update data',
                        position: 'topRight'
                    });
                }
            });
        });

        // DELETE
        $(document).on('click', '.btnDelete', function() {

            let id = $(this).data('id');
            let nama = $(this).data('nama');            

            if(confirm('Hapus ' + nama + ' Perusahan ini?')) {

                $.ajax({
                    url: '/adm/data-perusahaan/' + id,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function() {

                        iziToast.success({
                            title: 'Berhasil',
                            message: 'Data berhasil dihapus',
                            timeout: 1000,
                            position: 'topRight',
                            onClosing: function() {
                                location.reload();
                            }
                        });

                    },
                    error: function() {
                        iziToast.error({
                            title: 'Error',
                            message: 'Gagal menghapus data',
                            position: 'topRight'
                        });
                    }
                });

            }
        });
    </script>
@endsection
