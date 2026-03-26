@extends('template.main')
@section('title', 'Data Kelas | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Kelas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.jurusan.index')}}">Jurusan</a></div>
                <div class="breadcrumb-item">Daftar Kelas</div>
            </div>
        </div>

        <div class="section-body">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">

                    <div class="row align-items-center">

                        {{-- INFO JURUSAN --}}
                        <div class="col-md-6">

                            <div class="d-flex align-items-center">

                                <div class="mr-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:48px;height:48px;">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                </div>

                                <div>
                                    <div class="text-muted small">Jurusan</div>

                                    <h5 class="mb-0 font-weight-bold">
                                        {{ $jurusan->nama }}
                                    </h5>

                                    <small class="text-muted">
                                        Kode Jurusan: <b>{{ $jurusan->kode_jurusan }}</b> •
                                        Degree: <b>{{ $jurusan->degree }}</b>
                                    </small>
                                </div>

                            </div>

                        </div>


                        {{-- STATISTIK --}}
                        <div class="col-md-6">

                            <div class="row text-center">

                                <div class="col-6 border-right">
                                    <div class="text-muted small">Total Kelas</div>
                                    <div class="h4 font-weight-bold mb-0">
                                        {{ $totalKelas }}
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="text-muted small">Angkatan Aktif</div>
                                    <div class="h4 font-weight-bold mb-0">
                                        {{ $totalAngkatan }}
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>


            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

                <div>
                    <h2 class="section-title">
                        Daftar Kelas
                    </h2>
                    <p class="section-lead mb-0">
                        Kelas yang tersedia pada jurusan <b>{{ $jurusan->nama }}</b>
                    </p>
                </div>

            </div>


            <div class="row">
                <div class="col-12">

                    <div class="card">

                        <div class="card-header d-flex justify-content-between align-items-center mt-3 mx-3 flex-wrap">

                            <div class="pl-2">
                                <h4 class="mb-0 font-weight-bold">
                                    Data Kelas
                                </h4>
                            </div>

                            <div class="d-flex align-items-center flex-wrap pr-2 mt-3 mt-md-0">

                                <button class="btn btn-outline-primary rounded-pill px-3 mr-2"
                                        data-toggle="modal"
                                        data-target="#modalTambahKelas">
                                    <i class="fas fa-plus mr-1"></i> Tambah Kelas
                                </button>

                            </div>

                        </div>


                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-hover table-striped">

                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th class="text-center">Jurusan</th>
                                            <th class="text-center">Kode Kelas</th>
                                            <th class="text-center">Angkatan</th>
                                            <th class="text-center">Mahasiswa</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse($kelas as $k)

                                            <tr>

                                                <td>{{ $loop->iteration }}</td>

                                                <td class="text-center">
                                                    {{ $jurusan->kode_jurusan }}
                                                </td>

                                                <td class="text-center font-weight-bold">
                                                    {{ $k->kode_kelas }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $k->tahun_masuk }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $k->mahasiswa_count }}
                                                </td>

                                                <td class="text-center">

                                                    <a href="{{ route('admin.jurusan.kelas.mahasiswa', [$jurusan->kode_jurusan, $k->id]) }}"
                                                        class="btn btn-sm btn-outline-primary"
                                                        title="Lihat Mahasiswa">
                                                        <i class="fas fa-users"></i>
                                                    </a>

                                                    <button class="btn btn-sm btn-outline-secondary btn-edit"
                                                            data-id="{{ $k->id }}"
                                                            data-jurusan_id="{{ $k->jurusan_id }}"
                                                            data-kode_jurusan="{{ $jurusan->kode_jurusan }}"
                                                            data-jurusan="{{ $jurusan->nama }}"
                                                            data-kode_kelas="{{ $k->kode_kelas }}"
                                                            data-tahun_masuk="{{ $k->tahun_masuk }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-outline-danger btn-delete"
                                                            data-id="{{ $k->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="5" class="text-center text-muted">
                                                    Belum ada data kelas
                                                </td>
                                            </tr>

                                        @endforelse

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
    <div class="modal fade" id="modalTambahKelas" tabindex="-1">
        <div class="modal-dialog">
            <form id="formTambahKelas">
                @csrf

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kelas</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        {{-- Jurusan --}}
                        <div class="form-group">
                            <label>Jurusan</label>

                            <input type="text"
                                class="form-control"
                                value="{{ $jurusan->kode_jurusan }} - {{ $jurusan->nama }}"
                                readonly>

                            <input type="hidden"
                                name="jurusan_id"
                                value="{{ $jurusan->id }}">
                        </div>

                        {{-- Kode Kelas --}}
                        <div class="form-group">
                            <label>Kode Kelas</label>
                            <input type="text"
                                name="kode_kelas"
                                class="form-control"
                                placeholder="Contoh: 66"
                                required>
                        </div>

                        {{-- Tahun Masuk --}}
                        <div class="form-group">
                            <label>Tahun Masuk</label>
                            <input type="number"
                                name="tahun_masuk"
                                class="form-control"
                                placeholder="Contoh: 2024"
                                required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEditKelas" tabindex="-1">
        <div class="modal-dialog">
            <form id="formEditKelas">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="edit_id">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kelas</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        {{-- Jurusan --}}
                        <div class="form-group">
                            <label>Jurusan</label>

                            <input type="text"
                                id="edit_jurusan"
                                class="form-control"
                                readonly>

                            <input type="hidden"
                                name="jurusan_id"
                                id="edit_jurusan_id">
                        </div>

                        {{-- Kode Kelas --}}
                        <div class="form-group">
                            <label>Kode Kelas</label>
                            <input type="text"
                                name="kode_kelas"
                                id="edit_kode_kelas"
                                class="form-control"
                                required>
                        </div>

                        {{-- Tahun Masuk --}}
                        <div class="form-group">
                            <label>Tahun Masuk</label>
                            <input type="number"
                                name="tahun_masuk"
                                id="edit_tahun_masuk"
                                class="form-control"
                                required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#formTambahKelas').submit(function(e){

            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.jurusan.kelas.store', $jurusan->kode_jurusan) }}",
                type: "POST",
                data: $('#formTambahKelas').serialize(),
                success: function(res){

                    if(res.success){

                        $('#modalTambahKelas').modal('hide');

                        iziToast.success({
                            title: 'Berhasil',
                            message: res.message,
                            position: 'topRight',
                            timeout: 1000,
                            onClosing: function () {
                                location.reload();
                            }
                        });

                    }

                },
                error: function(xhr){

                    let err = xhr.responseJSON.errors;

                    let msg = Object.values(err)[0][0];

                    iziToast.error({
                        title: 'Gagal',
                        message: msg,
                        position: 'topRight'
                    });

                }
            });

        });


        $('.btn-edit').click(function(){

            let id = $(this).data('id');
            let jurusan = $(this).data('kode_jurusan') + ' - ' + $(this).data('jurusan');
            let jurusan_id = $(this).data('jurusan_id');
            let kode_kelas = $(this).data('kode_kelas');
            let tahun_masuk = $(this).data('tahun_masuk');

            $('#edit_id').val(id);
            $('#edit_jurusan').val(jurusan);
            $('#edit_jurusan_id').val(jurusan_id);
            $('#edit_kode_kelas').val(kode_kelas);
            $('#edit_tahun_masuk').val(tahun_masuk);

            $('#modalEditKelas').modal('show');

        });


        $('#formEditKelas').submit(function(e){

            e.preventDefault();

            let id = $('#edit_id').val();

            let url = "{{ route('admin.jurusan.kelas.update', [$jurusan->kode_jurusan, ':id']) }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "PUT",
                data: $(this).serialize(),

                success: function(res){

                    $('#modalEditKelas').modal('hide');

                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Perubahan kelas berhasil disimpan.',
                        position: 'topRight',
                        timeout: 1000,
                        onClosing: function () {
                            location.reload();
                        }
                    });


                },

                error: function(xhr){

                    let msg = 'Perubahan tidak dapat disimpan.';

                    if(xhr.responseJSON?.message){
                        msg = xhr.responseJSON.message;
                    }

                    if(xhr.responseJSON?.errors){
                        msg = Object.values(xhr.responseJSON.errors)[0][0];
                    }

                    iziToast.error({
                        title: 'Gagal',
                        message: msg,
                        position: 'topRight'
                    });

                }

            });

        });


        $('.btn-delete').click(function(){

            let id = $(this).data('id');

            if(!confirm('Anda akan menghapus kelas ini. Lanjutkan?')){
                return;
            }

            let url = "{{ route('admin.jurusan.kelas.destroy', [$jurusan->kode_jurusan, ':id']) }}";
            url = url.replace(':id', id);

            $.ajax({

                url: url,
                type: "DELETE",

                data:{
                    _token: "{{ csrf_token() }}"
                },

                success:function(res){

                    if(res.status === 'success'){

                        iziToast.success({
                            title:'Berhasil',
                            message: res.message,
                            position:'topRight',
                            timeout: 1000,
                            onClosing: function () {
                                location.reload();
                            }
                        });


                    } else if(res.status === 'warning'){

                        iziToast.warning({
                            title:'Perhatian',
                            message: res.message,
                            position:'topRight'
                        });

                    }

                },

                error:function(xhr){

                    let msg = 'Kelas tidak dapat dihapus.';

                    if(xhr.responseJSON?.message){
                        msg = xhr.responseJSON.message;
                    }

                    iziToast.error({
                        title:'Gagal',
                        message: msg,
                        position:'topRight'
                    });

                }

            });

        });
    </script>
@endsection