@extends('template.main')
@section('title', 'Dashboard | Tracer Study')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Overview Dashboard</h1>
        </div>

        {{-- ================= SUMMARY CARDS ================= --}}
        <div class="row">
            @php
                $stats = [
                    ['label' => 'Total Mahasiswa', 'value' => $totalMahasiswa, 'icon' => 'fas fa-users', 'color' => 'primary'],
                    ['label' => 'Rekanan Perusahaan', 'value' => $totalPerusahaan, 'icon' => 'fas fa-building', 'color' => 'info'],
                    ['label' => 'Total Penempatan', 'value' => $totalPenempatan, 'icon' => 'fas fa-briefcase', 'color' => 'success'],
                    ['label' => 'Interview (Bln Ini)', 'value' => $interviewBulanIni, 'icon' => 'fas fa-calendar-alt', 'color' => 'warning'],
                ];
            @endphp

            @foreach ($stats as $stat)
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 shadow-sm">
                    <div class="card-icon bg-{{ $stat['color'] }}">
                        <i class="{{ $stat['icon'] }}"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ $stat['label'] }}</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($stat['value']) }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            {{-- ================= DISTRIBUSI PENEMPATAN ================= --}}
            <div class="col-lg-6 col-md-12">
                <div class="card card-height shadow-sm" style="min-height: 400px;">
                    <div class="card-header border-0">
                        <h4>Distribusi Penempatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted font-weight-600">Magang</span>
                                <span class="badge badge-primary px-3">{{ $totalMagang }}</span>
                            </div>
                            <div class="progress" style="height:8px; border-radius: 10px;">
                                <div class="progress-bar bg-primary" 
                                    style="width: {{ $totalPenempatan > 0 ? ($totalMagang/$totalPenempatan)*100 : 0 }}%">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted font-weight-600">Kerja</span>
                                <span class="badge badge-success px-3">{{ $totalKerja }}</span>
                            </div>
                            <div class="progress" style="height:8px; border-radius: 10px;">
                                <div class="progress-bar bg-success" 
                                    style="width: {{ $totalPenempatan > 0 ? ($totalKerja/$totalPenempatan)*100 : 0 }}%">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row text-center mt-4">
                            <div class="col-6 border-right">
                                <div class="text-small font-weight-bold text-muted text-uppercase mb-1">Aktif</div>
                                <div class="h3 font-weight-bold text-info">{{ $penempatanAktif }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-small font-weight-bold text-muted text-uppercase mb-1">Selesai</div>
                                <div class="h3 font-weight-bold text-secondary">{{ $penempatanSelesai }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= TOP 5 PERUSAHAAN ================= --}}
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-sm" style="min-height: 400px;">
                    <div class="card-header border-0 d-flex justify-content-between">
                        <h4>Mitra Teraktif</h4>
                        <span class="badge badge-light">Top 5</span>
                    </div>
                    <div class="card-body">
                        @php $max = $topPerusahaan->max('penempatan_count'); @endphp
                        @foreach ($topPerusahaan as $index => $item)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-truncate" style="max-width: 80%;">
                                        <span class="text-muted mr-2">{{ $index + 1 }}.</span>
                                        <span class="font-weight-600 text-dark">{{ $item->nama_perusahaan }}</span>
                                    </div>
                                    <span class="font-weight-bold text-primary">{{ $item->penempatan_count }}</span>
                                </div>
                                <div class="progress mt-2" style="height:4px;">
                                    <div class="progress-bar bg-primary" 
                                        style="width: {{ $max > 0 ? ($item->penempatan_count/$max)*100 : 0 }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABLE PENEMPATAN TERAKHIR ================= --}}
        <div class="row mt-2">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header border-0 d-flex justify-content-between align-items-center">
                        <h4>Riwayat Penempatan Terakhir</h4>
                        <a href="{{ route('admin.penempatan.index')}}" class="btn btn-sm btn-primary btn-round px-3">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-md mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="pl-4">Mahasiswa</th>
                                        <th>Perusahaan</th>
                                        <th>Kategori</th>
                                        <th>Posisi</th>
                                        <th>Mulai</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penempatanTerbaru as $item)
                                        <tr>
                                            <td class="pl-4 font-weight-600">{{ $item->user->nama ?? '-' }}</td>
                                            <td>{{ $item->perusahaan->nama_perusahaan ?? '-' }}</td>
                                            <td>
                                                <span class="text-muted">{{ ucfirst($item->jenis) }}</span>
                                            </td>
                                            <td>{{ $item->posisi }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d M, Y') }}</td>
                                            <td class="text-center">
                                                @if($item->status == 'aktif')
                                                    <div class="badge badge-info shadow-sm">Aktif</div>
                                                @else
                                                    <div class="badge badge-secondary">Selesai</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted small">
                                                <i class="fas fa-folder-open d-block mb-2 fa-2x"></i>
                                                Belum ada data penempatan tersedia.
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
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function(){

        @if(session('success'))

            swal({
                title: "Login Berhasil",
                text: "{{ session('success') }}",
                icon: "success",
                button: "OK"
            });

        @endif

        });
    </script>
@endsection
