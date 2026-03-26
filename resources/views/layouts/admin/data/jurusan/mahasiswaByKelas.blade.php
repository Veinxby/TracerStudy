@extends('template.main')
@section('title', 'Data Mahasiswa By Kelas | Tracer Study')

@section('content')
    <section class="section">

        <div class="section-header">
            <h1>Data Mahasiswa By Kelas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.jurusan.index')}}">Jurusan</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.jurusan.kelas.index', $jurusan->kode_jurusan)}}">Kelas</a></div>
                <div class="breadcrumb-item">Mahasiswa By Kelas</div>
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
                                        <i class="fas fa-school"></i>
                                    </div>
                                </div>

                                <div>
                                    <div class="text-muted small">Kelas</div>

                                    <h5 class="mb-0 font-weight-bold">
                                        {{ $jurusan->nama }} ( {{ $jurusan->kode_jurusan }}{{ $kelas->kode_kelas }} )
                                    </h5>

                                    <small class="text-muted">
                                        Degree: <b>{{ $jurusan->degree }}</b> •
                                        Angkatan: <b>{{ $kelas->tahun_masuk }}</b>
                                    </small>
                                </div>

                            </div>

                        </div>


                        {{-- STATISTIK KELAS --}}
                        <div class="col-md-6">

                            <div class="row text-center">

                                <div class="col-3 border-right">
                                    <div class="text-muted small">Mahasiswa</div>
                                    <div class="h4 font-weight-bold mb-0">
                                        {{ $totalMahasiswa }}
                                    </div>
                                </div>

                                <div class="col-3 border-right">
                                    <div class="text-info small">IPK Rata</div>
                                    <div class="h4 font-weight-bold text-info mb-0">
                                        {{ $ipkRata ? number_format($ipkRata,2) : '-' }}
                                    </div>
                                </div>

                                <div class="col-3 border-right">
                                    <div class="text-muted small">Aktif</div>
                                    <div class="h4 font-weight-bold text-success mb-0">
                                        {{ $jumlahAktif }}
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="text-muted small">Lulus</div>
                                    <div class="h4 font-weight-bold text-primary mb-0">
                                        {{ $jumlahLulus }}
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

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
                                    <i class="fas fa-plus mr-1"></i> Tambah Mahasiswa
                                </button>

                            </div>

                        </div>

                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-hover table-striped">

                                    <thead>
                                        <tr>
                                            {{-- <th width="50">No</th> --}}
                                            <th class="text-center">NIPD</th>
                                            <th class="text-center">Nama Mahasiswa</th>
                                            <th class="text-center">IPK</th>
                                            <th class="text-center">No HP</th>
                                            <th class="text-center">Status Akademik</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse($mahasiswa as $m)

                                            <tr>

                                                {{-- <td>{{ $loop->iteration }}</td> --}}

                                                <td class="text-center">
                                                    @if($m)
                                                        <a href="{{ route('admin.mahasiswa.detail', $m->nipd) }}"
                                                        class="text-primary font-weight-bold">
                                                            {{ $m->nipd }}
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td class="text-center font-weight-bold">
                                                    {{ $m->user->nama }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $m->ipk ?? '0.00' }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $m->no_hp ?? '-' }}
                                                </td>

                                                <td>
                                                    <div class="dropdown" >
                                                        <span class=" badge badge-pill
                                                            @if($m->status_akademik=='aktif') badge-success
                                                            @elseif($m->status_akademik=='cuti') badge-primary
                                                            @elseif($m->status_akademik=='lulus') badge-info
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
                                                                data-status="lulus"
                                                                href="#">
                                                                <i class="fas fa-circle text-info mr-2"></i> Lulus
                                                            </a>

                                                            <a class="dropdown-item status-item"
                                                                data-status="tidak aktif"
                                                                href="#">
                                                                <i class="fas fa-circle text-danger mr-2"></i> Tidak Aktif
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-center">

                                                    <button class="btn btn-sm btn-outline-secondary btn-edit"
                                                            data-id="{{ $m->id }}"
                                                            data-nipd="{{ $m->nipd }}"
                                                            data-nama="{{ $m->user->nama }}"
                                                            data-ipk="{{ $m->ipk }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-outline-danger btn-delete"
                                                            data-id="{{ $m->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="5" class="text-center text-muted">
                                                    Belum ada mahasiswa di kelas ini
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
@endsection

@section('script')
    <script>
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
    </script>
@endsection