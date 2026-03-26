@extends('template.main')
@section('title', 'Data Jurusan | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Jurusan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data</div>
                <div class="breadcrumb-item">Jurusan</div>
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
                    <h2 class="section-title">
                        Daftar Jurusan & Informasi Kelas
                    </h2>
                    <p class="section-lead mb-0">
                        Jurusan dan Kelas dimulai dari angkatan 2021
                    </p>
                </div>

                <div class="d-flex mt-2 mt-md-0">

                    <div class="text-center mr-4">
                        <div class="text-muted small">Jurusan</div>
                        <div class="h4 font-weight-bold mb-0">{{ $totalJurusan }}</div>
                    </div>

                    <div class="text-center mr-4">
                        <div class="text-muted small">Kelas</div>
                        <div class="h4 font-weight-bold mb-0">{{ $totalKelas }}</div>
                    </div>

                    <div class="text-center">
                        <div class="text-muted small">Angkatan</div>
                        <div class="h4 font-weight-bold mb-0">{{ $totalAngkatan }}</div>
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class=" card-header d-flex justify-content-between align-items-center mt-3 mx-3 flex-wrap">

                            {{-- LEFT --}}
                            <div class="pl-2">
                                <h4 class="mb-0 font-weight-bold">
                                    Data Jurusan
                                </h4>
                            </div>

                            {{-- RIGHT --}}
                            <div class="d-flex align-items-center flex-wrap pr-2 mt-3 mt-md-0">

                                @if(auth()->user()->hasPermission('jurusan.create'))
                                    <button class="btn btn-outline-primary rounded-pill px-3 mr-2"
                                            data-toggle="modal"
                                            data-target="#modalTambahJurusan">
                                        <i class="fas fa-plus mr-1"></i> Tambah Jurusan
                                    </button>
                                @endif

                            </div>

                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="text-center">Kode Jurusan</th>
                                            <th>Jurusan</th>
                                            <th class="text-center">Degree</th>
                                            <th class="text-center">Lama Studi</th>
                                            <th class="text-center">Kelas</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jurusan as $j)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $j->kode_jurusan }}</td>
                                                <td>{{ $j->nama }}</td>
                                                <td class="text-center">{{ $j->degree ?? '-' }}</td>
                                                <td class="text-center">{{ $j->lama_studi ?? '-' }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-primary">
                                                        {{ $j->kelas_count }}
                                                    </span>
                                                </td>
                                                <td class="text-center">   

                                                    <a href="{{ route('admin.jurusan.kelas.index', $j->kode_jurusan) }}"
                                                        class="btn btn-sm btn-outline-primary"
                                                        title="Lihat daftar kelas">
                                                            <i class="fas fa-chalkboard"></i>
                                                    </a>


                                                    <button class="btn btn-sm btn-outline-secondary btn-edit"
                                                        data-id="{{ $j->id }}"
                                                        data-kode_jurusan="{{ $j->kode_jurusan }}"
                                                        data-nama="{{ $j->nama }}"
                                                        data-degree="{{ $j->degree }}"
                                                        data-lama="{{ $j->lama_studi }}"
                                                        data-toggle="modal"
                                                        data-target="#modalEditJurusan">

                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                
                                                
                                                    <form action="{{ route('admin.jurusan.destroy', $j->id) }}"
                                                        method="POST"
                                                        class="d-inline btn-hapus">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>      
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
    <div class="modal fade" id="modalTambahJurusan" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="formTambahJurusan">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Jurusan</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label>Kode Jurusan</label>
                                <input type="text" id="kode_jurusan" name="kode_jurusan" class="form-control" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Nama Jurusan</label>
                                <input type="text" id="nama" name="nama" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Degree</label>
                                <select id="degree" name="degree" class="form-control">
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Lama Studi</label>
                                <input type="number" id="lama_studi" name="lama_studi" class="form-control" min="1" max="5">
                            </div>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEditJurusan" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="formEditJurusan">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Jurusan</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-row">

                            <input type="hidden" id="edit_id" name="id">

                            <div class="form-group col-md-6">
                                <label>Kode Jurusan</label>
                                <input type="text" id="edit_kode_jurusan" name="kode_jurusan" class="form-control" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Nama Jurusan</label>
                                <input type="text" id="edit_nama" name="nama" class="form-control">
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label>Degree</label>
                                <select id="edit_degree" name="degree" class="form-control">
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Lama Studi</label>
                                <input type="number" id="edit_lama_studi" name="lama_studi" class="form-control" min="1" max="5">
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Update Data</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('input', '#nama', function () {

            let nama = $(this).val().trim();

            if(nama === ''){
                $('#kode_jurusan').val('');
                return;
            }

            let kode_jurusan = nama.split(/\s+/).map(w => w[0].toUpperCase()).join('');

            $('#kode_jurusan').val(kode_jurusan);

        });

        $(document).on('input', '#edit_nama', function () {

            let nama = $(this).val().trim();

            if(nama === ''){
                $('#edit_kode_jurusan').val('');
                return;
            }

            let kode_jurusan = nama.split(/\s+/).map(w => w[0].toUpperCase()).join('');

            $('#edit_kode_jurusan').val(kode_jurusan);

        });

        $(document).ready(function () {
            
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

        });


        $('#formTambahJurusan').submit(function(e){
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.jurusan.store') }}",
                type: "POST",
                data: $(this).serialize(),
                headers:{
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function(res){

                    $('#modalTambahJurusan').modal('hide');
                    $('#formTambahJurusan')[0].reset();

                    iziToast.success({
                        title: 'Berhasil',
                        message: res.message,
                        position: 'topRight',
                        timeout: 1000,
                        onClosing: function () {
                            location.reload();
                        }
                    });

                },
                error:function(xhr){

                    let msg = 'Terjadi kesalahan saat menyimpan data.';

                    if(xhr.responseJSON && xhr.responseJSON.message){
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


        // Edit
        $(document).on('click', '.btn-edit', function(){

            $('#edit_id').val($(this).data('id'));
            $('#edit_kode_jurusan').val($(this).data('kode_jurusan'));
            $('#edit_nama').val($(this).data('nama'));
            $('#edit_degree').val($(this).data('degree'));
            $('#edit_lama_studi').val($(this).data('lama'));

        });

        // Confirm Edit
        $('#formEditJurusan').submit(function(e){

            e.preventDefault();

            let id = $('#edit_id').val();

            $.ajax({

                url: "/adm/jurusan/" + id,
                type: "PUT",
                data: $(this).serialize(),

                headers:{
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },

                success:function(res){

                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Perubahan data jurusan berhasil disimpan.',
                        position: 'topRight',
                        timeout: 1000,
                        onClosing: function () {
                            location.reload();
                        }
                    });

                    $('#modalEditJurusan').modal('hide');

                },

                error:function(){

                    iziToast.error({
                        title: 'Gagal',
                        message: 'Perubahan data tidak berhasil disimpan. Silakan coba lagi.',
                        position: 'topRight'
                    });

                }

            });

        });


        // Delete
        $('.btn-hapus').submit(function(e){

            e.preventDefault();

            let form = this;

            if(confirm('Apakah Anda yakin ingin menghapus data jurusan ini?')){

                $.ajax({

                    url: $(form).attr('action'),
                    type: "POST",
                    data: $(form).serialize(),

                    success:function(){

                        iziToast.success({
                            title: 'Berhasil',
                            message: 'Data jurusan berhasil dihapus.',
                            position: 'topRight',
                            timeout: 1000,
                            onClosing: function () {
                                location.reload();
                            }
                        });

                    },

                    error:function(){

                        iziToast.error({
                            title: 'Gagal',
                            message: 'Data jurusan tidak dapat dihapus.',
                            position: 'topRight'
                        });

                    }

                });

            }

        });
        
    </script>
@endsection