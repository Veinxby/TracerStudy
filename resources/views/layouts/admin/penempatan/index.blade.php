@extends('template.main')
@section('title', 'Permintaan | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Kandidat Permintaan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Permintaan</div>
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
            {{-- @if(session('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                </div>
            @endif --}}

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <div>
                    <h2 class="section-title">Daftar Riwayat Permintaan/Penempatan</h2>
                    <p class="section-lead mb-0">Tabel Menampilkan Data Riwayat Permintaan Perusahaan</p>
                </div>
                <div class="text-right">
                    <div class="text-small font-weight-bold text-muted text-uppercase">
                        Total Data Permintaan
                    </div>

                    <div style="font-size:35px; font-weight:700;">
                        {{ number_format($totalPermintaan) }}
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
                                <a href="{{ route('admin.permintaan.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-hover" id="table-permintaan">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th>Kode</th>
                                            <th>Perusahaan</th>
                                            <th>Jenis</th>
                                            <th>Posisi</th>
                                            <th class="text-center">Kuota</th>
                                            <th>Tgl Panggilan</th>
                                            <th>Catatan</th>
                                            <th class="text-center">Status</th>
                                            <th style="width: 150px;">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permintaan as $p)
                                        <tr>
                                            <td class="text-nowrap align-middle">
                                                {{ $p->kode_permintaan }}
                                            </td>
                                            <td class="text-nowrap align-middle">
                                                {{ $p->perusahaan->nama_perusahaan }}
                                            </td>
                                            <td class="align-middle">
                                               {{ $p->jenis }}
                                            </td class="align-middle">
                                            <td class="align-middle">{{ $p->posisi }}</td>
                                            <td class="text-center align-middle">
                                                <span class="font-weight-bold {{ $p->details_count >= $p->kuota ? 'text-success' : 'text-warning' }}">
                                                    {{ $p->details_count }} / {{ $p->kuota }}
                                                        @if($p->details_count >= $p->kuota)
                                                            <i class="fas fa-check ml-1"></i>
                                                        @endif
                                                </span>
                                            </td>
                                            <td class="align-middle text-nowrap">
                                                {{ $p->tgl_panggilan ? \Carbon\Carbon::parse($p->tgl_panggilan)->format('d M Y') : '-' }}
                                            </td>
                                            <td class="text-truncate align-middle" style="max-width: 200px;">
                                               {{ $p->catatan ?? '-' }}
                                            </td>
                                            <td class="text-center align-middle">
                                                @php
                                                    $statusClass = [
                                                        'open' => 'primary',
                                                        'proses' => 'warning',
                                                        'selesai' => 'success',
                                                        'batal' => 'danger',
                                                    ];

                                                    $color = $statusClass[$p->status] ?? 'secondary';
                                                @endphp

                                                <span class="badge badge-{{ $color }} px-3 py-2 badge-pill">
                                                    {{ ucfirst($p->status) }}

                                                    @if($p->is_locked)
                                                        <i class="fas fa-lock ml-2"></i>
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center align-items-center flex-nowrap">
                                                    <a href="{{ route('admin.permintaan.kandidat.index', $p->id) }}" 
                                                    class="btn btn-sm btn-outline-primary mr-1" title="Kandidat">
                                                        <i class="fas fa-user-graduate"></i>
                                                    </a>

                                                    @if($p->is_locked && in_array(auth()->user()->role, ['it','adm_tracer']))
                                                        <form action="{{ route('admin.permintaan.unlock', $p->id) }}" 
                                                            method="POST" 
                                                            class="ml-1">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-secondary" 
                                                                    title="Unlock"
                                                                    onclick="return confirm('Buka kunci data ini?')">
                                                                <i class="fas fa-unlock"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        {{-- Unlock --}}
                                                        {{-- Tombol Edit --}}
                                                        <a href="{{ route('admin.permintaan.edit', $p->id) }}" 
                                                        class="btn btn-sm btn-outline-secondary mr-1" 
                                                        title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        {{-- Tombol Hapus --}}
                                                        <form action="{{ route('admin.permintaan.destroy', $p->id) }}" 
                                                            method="POST" 
                                                            class="m-0">
                                                            @csrf 
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Yakin ingin menghapus data ini?')" 
                                                                    title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
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
@endsection

@section('script')
    <script>
        $(function () {
            $('#table-permintaan').DataTable({
                order: [[4, 'desc']],
                columnDefs: [
                    { orderable: true, targets: [0,4] },
                    { orderable: false, targets: '_all' }
                ],
            });
        });

        @if(session('success'))

            swal({
                title: "Login Berhasil",
                text: "{{ session('success') }}",
                icon: "success",
                button: "OK"
            });

        @endif
    </script>
@endsection
