@extends('template.main')
@section('title', 'Detail Mahasiswa | Tracer Study')
@section('style')
    <style>
        .timeline-limit {
            max-height: 480px;
            overflow: hidden;
            position: relative;
            transition: all .3s ease;
        }

        .timeline-limit.no-fade:after {
            display: none;
        }

        /* efek gradasi biar keliatan masih ada */
        .timeline-limit:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 120px;
            background: linear-gradient(to bottom, 
                        rgba(255,255,255,0) 0%, 
                        rgba(255,255,255,0.9) 70%, 
                        rgba(255,255,255,1) 100%);
        }

        .timeline-limit.opened:after{
            display: none;
        }

        .timeline-wrapper.open .timeline-limit {
            max-height: 100%;
            overflow: visible;
        }

        .timeline-wrapper.open .timeline-limit:after {
            display: none;
        }

        .domisili-text {
            display: -webkit-box;
            -webkit-line-clamp: 2;   /* jumlah baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Tracer Study Mahasiswa</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap p-3 border-bottom">
                            <div>
                                <h4 class="mb-0">Profil & Riwayat Karir</h4>
                            </div>
                            <div class="mt-2 mt-md-0">
                                <a href="/adm/data-mhs" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <div class="card border-0 shadow-sm w-100">
                                        <div class="card-body p-4">
                                            <div class="text-center mb-4">
                                                <div class="bg-gradient-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow" 
                                                    style="width: 90px; height: 90px; font-size: 2rem; background: linear-gradient(45deg, #6777ef, #acb5f6);">
                                                    @php
                                                        $inisial = Str::of($mahasiswa->user->nama)
                                                            ->explode(' ')
                                                            ->map(fn($item) => strtoupper(substr($item, 0, 1)))
                                                            ->take(2)
                                                            ->join('');
                                                    @endphp
                                                    {{ $inisial }}
                                                </div>
                                                <h5 class="font-weight-bold mt-3 mb-0 text-dark">{{ $mahasiswa->user->nama }}</h5>
                                                <p class="text-muted small">ID: {{$mahasiswa->nipd}}</p>
                                            </div>

                                            <div class="text-center mb-4">
                                                @php
                                                    $status_color = [
                                                        'available' => 'badge-secondary',
                                                        'on_proses' => 'badge-warning',
                                                        'magang'    => 'badge-info',
                                                        'kerja'     => 'badge-success'
                                                    ];
                                                @endphp
                                                <span class="badge {{ $status_color[$mahasiswa->status_kerja] ?? 'badge-light' }} px-3 py-2 shadow-sm" style="letter-spacing: 1px; font-size: 10px;">
                                                    <i class="fas fa-circle mr-1" style="font-size: 8px;"></i> 
                                                    {{ strtoupper(str_replace('_', ' ', $mahasiswa->status_kerja)) }}
                                                </span>
                                            </div>

                                            <hr class="my-4">

                                            <div class="row text-left">
                                                <div class="col-6 mb-3">
                                                    <small class="text-muted text-uppercase font-weight-bold" style="font-size: 10px;">Jurusan</small>
                                                    <p class="mb-0 font-weight-bold text-dark">{{ $mahasiswa->kelas->jurusan_id }}{{ $mahasiswa->kelas->kode_kelas }}</p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <small class="text-muted text-uppercase font-weight-bold" style="font-size: 10px;">Angkatan</small>
                                                    <p class="mb-0 font-weight-bold text-dark">{{$mahasiswa->kelas->tahun_masuk}}</p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <small class="text-muted text-uppercase font-weight-bold" style="font-size: 10px;">IPK Terakhir</small>
                                                    <div class="d-flex align-items-center">
                                                        <p class="mb-0 font-weight-bold text-primary mr-2" style="font-size: 1.1rem;">{{ $mahasiswa->ipk ?? '0.00' }}</p>
                                                        <div class="progress w-100" style="height: 4px;">
                                                            <div class="progress-bar bg-primary" style="width: {{ ($mahasiswa->ipk / 4) * 100 }}%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <small class="text-muted text-uppercase font-weight-bold" style="font-size: 10px;">
                                                        Status Akademik
                                                    </small>

                                                    @php
                                                        $statusAkademikColor = [
                                                            'aktif' => 'badge-success',
                                                            'cuti' => 'badge-warning',
                                                            'tidak aktif' => 'badge-danger',
                                                        ];
                                                    @endphp

                                                    <div class="mt-1">
                                                        <span class="badge {{ $statusAkademikColor[strtolower($mahasiswa->status_akademik)] ?? 'badge-secondary' }}">
                                                            {{ strtoupper($mahasiswa->status_akademik ?? '-') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3 p-3 bg-light rounded shadow-none">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-phone text-muted mr-3" style="width: 20px;"></i>
                                                    <span class="small font-weight-bold">{{$mahasiswa->no_hp ?? 'Belum isi'}}</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-envelope text-muted mr-3" style="width: 20px;"></i>
                                                    <span class="small font-weight-bold text-truncate">{{ $mahasiswa->user->email ?? 'Belum isi' }}</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-map-marker-alt mr-3" style="width: 20px;"></i>
                                                    <span class="small font-weight-bold">
                                                        {{ $mahasiswa->domisili ?? '-' }}
                                                    </span>
                                                </div>
                                            </div>

                                            <button class="btn btn-outline-primary btn-block btn-sm mt-4 font-weight-bold">
                                                <i class="fas fa-edit mr-1"></i> Edit Profil
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-8 d-flex">
                                    <div class="card border-0 shadow-sm w-100">
                                        <div class="card-body p-0">
                                            <ul class="nav nav-tabs nav-justified border-0 bg-light" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active py-3 border-0 font-weight-bold" data-toggle="tab" href="#tab-interview">
                                                        <i class="fas fa-comments mr-2"></i>Interviews
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link py-3 border-0 font-weight-bold" data-toggle="tab" href="#tab-magang">
                                                        <i class="fas fa-university mr-2"></i>Magang
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link py-3 border-0 font-weight-bold" data-toggle="tab" href="#tab-kerja">
                                                        <i class="fas fa-briefcase mr-2"></i>Kerja
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content p-4" style="min-height: 400px;">
                                                

                                                <div class="tab-pane fade show active" id="tab-interview">
                                                    <div class="timeline-wrapper" id="interviewWrapper">
                                                        <div class="timeline-limit">
                                                            {{-- Kita urutkan koleksi dari yang terbaru --}}
                                                            @php
                                                                $daftarInterview = $mahasiswa->interviews;
                                                            @endphp

                                                            @forelse($daftarInterview as $item)
                                                                @php
                                                                    $hasil = strtolower($item->hasil);
                                                                    $isLulus = in_array($hasil, ['lulus', 'diterima', 'lolos']);

                                                                    $badgeClass = $isLulus ? 'badge-success' : 'badge-danger';
                                                                    $textColor  = $isLulus ? 'text-success' : 'text-danger';

                                                                    // Inisial Perusahaan
                                                                    $namaPers = $item->perusahaan->nama_perusahaan ?? '??';
                                                                    $words = explode(' ', preg_replace('/[^A-Za-z0-9 ]/', '', $namaPers));
                                                                    $inisial = count($words) >= 2 
                                                                        ? strtoupper(substr($words[0],0,1) . substr($words[1],0,1))
                                                                        : strtoupper(substr($namaPers,0,2));
                                                                @endphp

                                                                <div class="d-flex mb-4">

                                                                    {{-- Inisial --}}
                                                                    <div class="mr-3 text-center">
                                                                        <div class="bg-light rounded border d-flex align-items-center justify-content-center"
                                                                            style="width:48px;height:48px;">
                                                                            <span class="font-weight-bold {{ $textColor }}">
                                                                                {{ $inisial }}
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Card --}}
                                                                    <div class="flex-grow-1 bg-white border rounded p-3">

                                                                        <div class="d-flex justify-content-between align-items-start">
                                                                            <div>
                                                                                <h6 class="font-weight-bold mb-0 text-dark">
                                                                                    {{ $namaPers }}
                                                                                </h6>
                                                                                <p class="small font-weight-bold mb-1 text-primary">
                                                                                    {{ $item->posisi ?? '-' }}
                                                                                </p>
                                                                            </div>

                                                                            <span class="badge badge-pill {{ $badgeClass }} px-3 py-1 text-uppercase"
                                                                                style="font-size:10px; letter-spacing:.5px;">
                                                                                {{ $item->hasil }}
                                                                            </span>
                                                                        </div>

                                                                        <div class="mt-2 pt-2 border-top">
                                                                            <small class="text-muted">
                                                                                <i class="far fa-calendar-alt mr-1"></i>
                                                                                {{ \Carbon\Carbon::parse($item->tgl_interview)->translatedFormat('d M Y') }}
                                                                            </small>
                                                                        </div>

                                                                        @if($item->keterangan && $item->keterangan != '-')
                                                                            <div class="mt-2">
                                                                                <small class="text-muted font-italic">
                                                                                    Catatan: "{{ $item->keterangan }}"
                                                                                </small>
                                                                            </div>
                                                                        @endif

                                                                    </div>

                                                                </div>

                                                            @empty
                                                                <div class="text-center py-5">
                                                                    <i class="fas fa-calendar-times fa-3x text-light mb-3"></i>
                                                                    <p class="text-muted">Belum ada riwayat interview.</p>
                                                                </div>
                                                            @endforelse
                                                        </div>

                                                        <div class="text-center mt-3">
                                                            <button class="btn btn-sm btn-outline-primary toggle-btn"
                                                                data-target="#interviewWrapper">
                                                                ▼ Show More
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>


                                                {{-- Tab Magang --}}
                                                <div class="tab-pane fade" id="tab-magang">
                                                    <div class="timeline-wrapper" id="magangWrapper">
                                                        <div class="timeline-limit">
                                                            @php
                                                                $magang = $mahasiswa->penempatan
                                                                    ->where('jenis', 'magang')
                                                                    ->sortByDesc('tgl_mulai');
                                                            @endphp
                                                            @forelse($magang as $mg)
                                                                @php
                                                                    // Logika Status Warna
                                                                    $status = strtolower($mg->status);
                                                                    $badgeColor = 'secondary';
                                                                    if($status == 'berjalan') $badgeColor = 'info';
                                                                    if($status == 'selesai') $badgeColor = 'success';
                                                                    if($status == 'perpanjang') $badgeColor = 'primary';

                                                                    // Hitung Durasi (Carbon)
                                                                    $mulai = \Carbon\Carbon::parse($mg->tgl_mulai);

                                                                    $selesai = $mg->tgl_selesai 
                                                                        ? \Carbon\Carbon::parse($mg->tgl_selesai) 
                                                                        : null;

                                                                    if ($selesai) {
                                                                        $diff = $mulai->diff($selesai);

                                                                        $durasi = 
                                                                            ($diff->y ? $diff->y . ' tahun ' : '') .
                                                                            ($diff->m ? $diff->m . ' bulan ' : '') .
                                                                            ($diff->d ? $diff->d . ' hari' : '');
                                                                    } else {
                                                                        $durasi = null; // bukan masih berjalan
                                                                    }

                                                                    // Ambil 2 Inisial Nama Perusahaan
                                                                    $namaPers = $mg->perusahaan->nama_perusahaan ?? '??';
                                                                    $words = explode(' ', preg_replace('/[^A-Za-z0-9 ]/', '', $namaPers));
                                                                    $inisialMg = count($words) >= 2 
                                                                        ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1)) 
                                                                        : strtoupper(substr($namaPers, 0, 2));
                                                                @endphp

                                                                <div class="d-flex mb-4">
                                                                    <div class="mr-3 text-center">
                                                                        <div class="bg-light rounded p-2 border d-flex align-items-center justify-content-center shadow-sm" 
                                                                            style="width: 48px; height: 48px; overflow: hidden; background-color: #f8f9fa !important;">
                                                                            <span class="font-weight-bold text-info" style="font-size: 1.1rem;">{{ $inisialMg }}</span>
                                                                        </div>
                                                                        @if(!$loop->last)
                                                                            <div class="h-100 border-left mx-auto mt-2" style="width: 2px; border-left: 2px dashed #dee2e6 !important;"></div>
                                                                        @endif
                                                                    </div>

                                                                    <div class="flex-grow-1 bg-white border rounded p-3 shadow-none">
                                                                        <div class="d-flex justify-content-between align-items-start">
                                                                            <div>
                                                                                <h6 class="font-weight-bold text-dark mb-0">{{ $namaPers }}</h6>
                                                                                <p class="small text-info font-weight-bold mb-1">{{ $mg->posisi }}</p>
                                                                            </div>
                                                                            <span class="badge badge-{{ $badgeColor }} px-2 py-1 text-uppercase" style="font-size: 9px; letter-spacing: 0.5px;">
                                                                                {{ $mg->status }}
                                                                            </span>
                                                                        </div>

                                                                        <div class="mt-2 pt-2 border-top">
                                                                            <div class="d-flex align-items-center mb-2">
                                                                                <small class="text-muted">
                                                                                    <i class="far fa-calendar-alt mr-1"></i> 
                                                                                    {{ $mulai->translatedFormat('d M Y') }} - 
                                                                                    {{ $selesai ? $selesai->translatedFormat('d M Y') : '???' }}
                                                                                    @if($durasi)
                                                                                        <span class="badge badge-light ml-2">({{ trim($durasi) }})</span>
                                                                                    @endif
                                                                                </small>
                                                                            </div>
                                                                            
                                                                            @if($mg->keterangan)
                                                                                <p class="small text-muted mb-0 font-italic" style="line-height: 1.4;">
                                                                                    Catatan : "{{ $mg->keterangan }}"
                                                                                </p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                <div class="text-center py-5">
                                                                    <i class="fas fa-university fa-3x text-light mb-3"></i>
                                                                    <p class="text-muted">Data magang belum tersedia.</p>
                                                                </div>
                                                            @endforelse
                                                        </div>

                                                        <div class="text-center mt-3">
                                                            <button class="btn btn-sm btn-outline-primary toggle-btn"
                                                                data-target="#magangWrapper">
                                                                ▼ Show More
                                                            </button>
                                                        </div>
                                                    </div>   
                                                </div>


                                                {{-- Tab Kerja --}}
                                                <div class="tab-pane fade" id="tab-kerja">
                                                    <div class="timeline-wrapper" id="kerjaWrapper">
                                                        <div class="timeline-limit">
                                                            @php
                                                                $kerja = $mahasiswa->penempatan
                                                                    ->where('jenis', 'kerja')
                                                                    ->sortByDesc('tgl_mulai');
                                                            @endphp

                                                            @forelse($kerja as $krj)
                                                                @php
                                                                    $status = strtolower($krj->status);
                                                                    $isAktif = ($status === 'aktif');
                                                                    
                                                                    // Styling dinamis
                                                                    $cardBg = 'bg-white';
                                                                    $borderColor = $isAktif ? 'border-success' : '';
                                                                    $textClass = $isAktif ? 'text-success' : 'text-muted';
                                                                    $badgeClass = $isAktif ? 'badge-success' : 'badge-light border';
                                                                    
                                                                    // Inisial Perusahaan
                                                                    $namaPers = $krj->perusahaan->nama_perusahaan ?? '??';
                                                                    $words = explode(' ', preg_replace('/[^A-Za-z0-9 ]/', '', $namaPers));
                                                                    $inisialKrj = count($words) >= 2 
                                                                        ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1)) 
                                                                        : strtoupper(substr($namaPers, 0, 2));

                                                                    // Tanggal Logic
                                                                    $mulai = \Carbon\Carbon::parse($krj->tgl_mulai);
                                                                    $selesai = $krj->tgl_selesai 
                                                                        ? \Carbon\Carbon::parse($krj->tgl_selesai)
                                                                        : null;

                                                                    $diff = $selesai ? $mulai->diff($selesai) : null;

                                                                    if ($diff) {
                                                                        $durasi =
                                                                            ($diff->y ? $diff->y . ' th ' : '') .
                                                                            ($diff->m ? $diff->m . ' bln ' : '') .
                                                                            ($diff->d ? $diff->d . ' hr' : '');
                                                                    } else {
                                                                        $durasi = null;
                                                                    }
                                                                @endphp

                                                                <div class="d-flex mb-4">
                                                                    <div class="mr-3 text-center">
                                                                        <div class="bg-light rounded p-2 border d-flex align-items-center justify-content-center shadow-sm" 
                                                                            style="width: 55px; height: 55px;">
                                                                            <span class="font-weight-bold {{ $textClass }}">{{ $inisialKrj }}</span>
                                                                        </div>
                                                                        @if(!$loop->last)
                                                                            <div class="h-100 border-left mx-auto mt-2" style="width: 2px; border-left: 2px solid #dee2e6 !important;"></div>
                                                                        @endif
                                                                    </div>

                                                                    <div class="flex-grow-1 {{ $cardBg }} border rounded p-3 {{ $borderColor }}" 
                                                                        @if($isAktif) style="border-left-width: 4px !important;" @endif>
                                                                        
                                                                        <div class="d-flex justify-content-between align-items-start">
                                                                            <div class="{{ !$isAktif ? 'text-muted' : '' }}">
                                                                                <h6 class="font-weight-bold mb-0 {{ $isAktif ? 'text-dark' : '' }}">
                                                                                    {{ $namaPers }}
                                                                                </h6>
                                                                                <p class="small font-weight-bold mb-1 {{ $textClass }}">
                                                                                    {{ $krj->posisi }}
                                                                                </p>
                                                                            </div>
                                                                            <span class="badge {{ $badgeClass }} px-2 py-1 text-uppercase" style="font-size: 10px;">
                                                                                {{ $isAktif ? 'AKTIF BEKERJA' : 'SELESAI / RESIGN' }}
                                                                            </span>
                                                                        </div>

                                                                        <div class="mt-2 pt-2 border-top">
                                                                            {{-- Tipe + Sumber --}}
                                                                            <small class="text-muted d-block mb-1">
                                                                                <i class="fas fa-tags mr-1"></i>
                                                                                Tipe: {{ $krj->tipe_kontrak ?? '-' }}

                                                                                <span class="mx-2">|</span>

                                                                                <i class="fas fa-share-alt mr-1"></i>
                                                                                Sumber:
                                                                                <span class="badge badge-light border">
                                                                                    {{ strtoupper($krj->sumber ?? '-') }}
                                                                                </span>
                                                                            </small>

                                                                            {{-- Tanggal --}}
                                                                            <small class="text-muted">
                                                                                <i class="far fa-calendar-alt mr-1"></i> 
                                                                                {{ $mulai->translatedFormat('d M Y') }} -

                                                                                @if($isAktif)
                                                                                    Sekarang
                                                                                @elseif($selesai)
                                                                                    {{ $selesai->translatedFormat('d M Y') }}
                                                                                @else
                                                                                    ???
                                                                                @endif

                                                                                @if($durasi)
                                                                                    <span class="badge badge-light ml-2">
                                                                                        ({{ trim($durasi) }})
                                                                                    </span>
                                                                                @endif
                                                                            </small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                <div class="text-center py-5">
                                                                    <i class="fas fa-briefcase fa-3x text-light mb-3"></i>
                                                                    <p class="text-muted">Mahasiswa ini belum memiliki riwayat kerja.</p>
                                                                </div>
                                                            @endforelse
                                                        </div>

                                                        <div class="text-center mt-3">
                                                            <button class="btn btn-sm btn-outline-primary toggle-btn"
                                                                data-target="#kerjaWrapper">
                                                                Show All
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
       const LIMIT_HEIGHT = 480;
 
        function checkManualLimit() {

            $('.timeline-wrapper').each(function () {

                let wrapper = $(this);
                let limit = wrapper.find('.timeline-limit')[0];
                let btn = wrapper.find('.toggle-btn');
                let btnArea = btn.parent();

                if (!limit) return;

                let contentHeight = limit.scrollHeight;

                if (contentHeight > LIMIT_HEIGHT) {
                    btnArea.show();
                } else {
                    btnArea.hide();
                }
            });
        }

        $(document).ready(function(){

            $('.timeline-limit').each(function(){

                if (this.scrollHeight <= this.clientHeight) {

                    $(this).addClass('no-fade');

                    $(this).closest('.timeline-wrapper')
                        .find('.toggle-btn')
                        .hide();
                }

            });

        });

        // saat pertama load
        $(window).on('load', function () {
            checkManualLimit();
        });

        // 🔥 penting → saat pindah tab
        $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
            checkManualLimit();
        });


        // tombol
        $(document).on('click', '.toggle-btn', function () {

            let wrapper = $($(this).data('target'));
            let limit = wrapper.find('.timeline-limit');

            wrapper.toggleClass('open');

            if (wrapper.hasClass('open')) {
                limit.css('max-height', 'none').addClass('opened');
                $(this).text('▲ Show Less');
            } else {
                limit.css('max-height', LIMIT_HEIGHT + 'px').removeClass('opened');
                $(this).text('▼ Show More');
            }
        });
    </script>
@endsection