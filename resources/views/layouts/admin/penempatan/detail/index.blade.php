@extends('template.main')
@section('title', 'Proses Permintaan | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Kandidat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('admin.permintaan.index')}}">Permintaan</a></div>
                <div class="breadcrumb-item">Kandidat</div>
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
            @if(session('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <div>
                    <h2 class="section-title">Daftar Kandidat</h2>
                    <p class="section-lead mb-0">Kandidat untuk posisi <b>{{ $permintaan->posisi }}</b></p>
                </div>
                <div class="text-right">
                    <div class="text-small font-weight-bold text-muted text-uppercase">
                        Total Kuota
                    </div>

                    <div style="font-size:35px; font-weight:700;" class="{{ $kandidat->count() >= $permintaan->kuota ? 'text-danger' : '' }}">
                        {{ $kandidat->count() }} / {{ $permintaan->kuota }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">Daftar Riwayat Permintaan/Penempatan</h4>
                            </div>

                            <div>
                                @php
                                    $isFull = $kandidat->count() >= $permintaan->kuota;
                                    $isSelesai = $permintaan->status === 'selesai';
                                    $hasKandidat = $kandidat->count() > 0;
                                @endphp

                                {{-- Tombol Proses Hasil Seleksi --}}
                                @if(!$isSelesai && $hasKandidat)
                                    <a href="{{ route('admin.permintaan.kandidat.proses', $permintaan->id) }}"
                                    class="btn btn-outline-primary">
                                        <i class="fas fa-tasks"></i> Proses Hasil Seleksi
                                    </a>
                                @elseif($isSelesai)
                                    <button class="btn btn-outline-success" disabled>
                                        <i class="fas fa-check-circle"></i> Sudah Diproses
                                    </button>
                                @endif

                                @if(!$isFull && !$isSelesai)
                                    <a href="{{ route('admin.permintaan.kandidat.create', $permintaan->id) }}"
                                    class="btn btn-outline-primary">
                                        <i class="fas fa-user-plus"></i> Tambah Kandidat
                                    </a>
                                @elseif($isSelesai)
                                    <button class="btn btn-outline-success" disabled>
                                        <i class="fas fa-lock"></i> Permintaan Selesai
                                    </button>
                                @else
                                    <button class="btn btn-outline-secondary" disabled>
                                        <i class="fas fa-user-minus"></i> Kuota Penuh
                                    </button>
                                @endif
                                
                            </div>
                            
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-hover" id="table-kandidat">
                                    <thead>
                                        <tr>
                                            <th width="40">No</th>
                                            <th>NIPD</th>
                                            <th>Nama</th>
                                            <th>Jurusan</th>
                                            <th class="text-center">IPK</th>
                                            <th class="text-center">Status</th>
                                            <th width="120">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kandidat as $i => $k)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    @if($k->mahasiswa)
                                                        <a href="{{ route('admin.mahasiswa.detail', $k->mahasiswa->nipd) }}"
                                                        class="text-primary font-weight-bold">
                                                            {{ $k->mahasiswa->nipd }}
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $k->mahasiswa->user->nama ?? '-' }}</td>
                                                <td>{{ $k->mahasiswa->kelas->jurusan->nama ?? '-' }}</td>
                                                <td class="text-center">{{ $k->mahasiswa->ipk ?? '-' }}</td>

                                                <td class="text-center">
                                                    {{ $k->status }}
                                                </td>

                                                <td>
                                                    @if(!$isSelesai)
                                                        <a href="{{ route('admin.permintaan.kandidat.edit', [$permintaan->id, $k->id]) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('admin.permintaan.kandidat.destroy', [$permintaan->id, $k->id]) }}"
                                                            method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus kandidat ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-outline-danger">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-sm btn-secondary" disabled>
                                                            Terkunci
                                                        </button>
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
@endsection

@section('script')
    <script>
        $("#table-kandidat").dataTable({
        "columnDefs": [
            { "sortable": false, "targets": [0,3] }
        ]
        });
    </script>
@endsection