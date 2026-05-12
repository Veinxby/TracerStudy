@extends('layouts.mahasiswa')
@section('title', 'Dashboard | OASIS LP3I Banten')
    
@section('content')
    <!-- Welcome Banner -->
    <section class="welcome-banner">
        <div class="container-fluid px-3 px-lg-4">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="welcome-text">

                        <h1>Selamat Datang, <span>{{$nama}}</span> 👋</h1>
                        <p>NIM: {{$nim}} — Program Studi: {{$jurusan}}</p>

                        <div class="welcome-badges">
                            @if($statusAkademik == 'aktif')
                                <span class="badge-semester">
                                    <i class="fas fa-layer-group"></i> Semester {{ $semester }}
                                </span>
                            @endif

                            <span class="badge-status">
                                <i class="fas fa-check-circle">
                            </i> {{ ucfirst($statusAkademik) }}</span>
                        </div>

                        <div class="profile-status-box mt-3">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>
                                Data diri kamu belum lengkap.
                                <a href="/profile">Lengkapi sekarang</a>
                            </span>
                        </div>
                        
                    </div>
                </div>
                <div class="col-12 col-lg-5 d-lg-block d-md-block">
                    <div class="card stats-card">
                        <div class="stats-top">
                            <div>
                                <div class="label">Magang</div>
                                <div class="value">{{ $totalMagang }}</div>
                            </div>
                            <div class="text-end">
                                <div class="label">Interview</div>
                                <div class="value">{{ $totalInterview }}</div>
                            </div>
                        </div>

                        <div class="stats-divider"></div>

                        <div class="stats-bottom">
                            <div class="label">Status Magang</div>
                            <div class="status 
                                @if($statusMagang == 'Available') available
                                @elseif($statusMagang == 'Pending') pending
                                @else rejected
                                @endif
                            ">
                                {{ $statusMagang }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats -->
    {{-- <section class="stats-section">
        <div class="container-fluid px-3 px-lg-4">
            <div class="row">
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-card stat-ipk">
                        <div class="stat-icon"><i class="fas fa-chart-bar"></i></div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $ipk }}</span>
                            <span class="stat-label">IPK Kumulatif</span>
                        </div>
                        <div class="stat-trend up"><i class="fas fa-arrow-up"></i> +0.05</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-card stat-sks">
                        <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                        <div class="stat-content">
                            <span class="stat-value">96 <small>/ 144</small></span>
                            <span class="stat-label">SKS Ditempuh</span>
                        </div>
                        <div class="stat-progress">
                            <div class="progress-bar-custom" style="width: 66%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-card stat-tagihan">
                        <div class="stat-icon"><i class="fas fa-hand-holding-usd"></i></div>
                        <div class="stat-content">
                            <span class="stat-value">Rp 2.5 <small>Jt</small></span>
                            <span class="stat-label">Sisa Tagihan</span>
                        </div>
                        <div class="stat-trend down"><i class="fas fa-exclamation-triangle"></i> Belum Lunas</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-card stat-magang">
                        <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $statusMagang }}</span>
                            <span class="stat-label">Status Magang</span>
                        </div>

                        @if($perusahaanAktif)
                            <div class="stat-trend up">
                                <i class="fas fa-building"></i> {{ $perusahaanAktif }}
                            </div>
                            @else
                            <div class="stat-trend up"><i class="fas fa-building"></i> -</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Payment Status Section -->
    {{-- <section class="payment-section" id="pembayaran">
        <div class="container-fluid px-3 px-lg-4">
            <div class="section-header">
                <h5><i class="fas fa-credit-card"></i> Status Pembayaran</h5>
                <a href="#riwayat-bayar" class="btn-view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="payment-main-card">
                        <div class="payment-header">
                            <div class="payment-semester">
                                <h5>Semester Ganjil 2024/2025</h5>
                                <span class="payment-status-badge pending">Belum Lunas</span>
                            </div>
                            <div class="payment-date">Jatuh Tempo: <strong>15 Januari 2025</strong></div>
                        </div>
                        <div class="payment-body">
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <div class="payment-info-box">
                                        <span class="label">Total Tagihan</span>
                                        <span class="value text-dark">Rp 5.000.000</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="payment-info-box">
                                        <span class="label">Sudah Dibayar</span>
                                        <span class="value text-success">Rp 2.500.000</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="payment-info-box">
                                        <span class="label">Sisa Tagihan</span>
                                        <span class="value text-danger">Rp 2.500.000</span>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-progress-wrap">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="progress-label">Progress Pembayaran</span>
                                    <span class="progress-percent">50%</span>
                                </div>
                                <div class="payment-progress-bar">
                                    <div class="payment-progress-fill" style="width: 50%"></div>
                                </div>
                            </div>
                            <div class="payment-actions">
                                <button class="btn-pay-now"><i class="fas fa-credit-card"></i> Bayar Sekarang</button>
                                <button class="btn-pay-detail"><i class="fas fa-receipt"></i> Lihat Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="payment-history-card">
                        <h6>Riwayat Pembayaran Terakhir</h6>
                        <div class="payment-history-list">
                            <div class="payment-history-item">
                                <div class="payment-history-icon success"><i class="fas fa-check"></i></div>
                                <div class="payment-history-info">
                                    <span class="desc">Cicilan ke-2 Semester 5</span>
                                    <span class="date">12 Des 2024</span>
                                </div>
                                <span class="amount">Rp 1.500.000</span>
                            </div>
                            <div class="payment-history-item">
                                <div class="payment-history-icon success"><i class="fas fa-check"></i></div>
                                <div class="payment-history-info">
                                    <span class="desc">Cicilan ke-1 Semester 5</span>
                                    <span class="date">15 Okt 2024</span>
                                </div>
                                <span class="amount">Rp 1.000.000</span>
                            </div>
                            <div class="payment-history-item">
                                <div class="payment-history-icon success"><i class="fas fa-check"></i></div>
                                <div class="payment-history-info">
                                    <span class="desc">Lunas Semester 4</span>
                                    <span class="date">28 Jul 2024</span>
                                </div>
                                <span class="amount">Rp 5.000.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Transcript Section -->
    {{-- <section class="transcript-section" id="transkrip">
        <div class="container-fluid px-3 px-lg-4">
            <div class="section-header">
                <h5><i class="fas fa-file-alt"></i> Transkrip Nilai</h5>
                <div class="section-actions">
                    <select class="form-control-sm custom-select" id="semesterFilter" onchange="filterSemester()">
                        <option value="all">Semua Semester</option>
                        <option value="5">Semester 5 (Aktif)</option>
                        <option value="4">Semester 4</option>
                        <option value="3">Semester 3</option>
                        <option value="2">Semester 2</option>
                        <option value="1">Semester 1</option>
                    </select>
                    <button class="btn-print" onclick="printTranscript()"><i class="fas fa-print"></i> Cetak</button>
                </div>
            </div>
            <div class="transcript-card">
                <div class="table-responsive">
                    <table class="table transcript-table" id="transcriptTable">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th class="text-center">SKS</th>
                                <th class="text-center">Nilai</th>
                                <th class="text-center">Bobot</th>
                                <th>Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-semester="5">
                                <td><span class="code-badge">MI501</span></td>
                                <td>Machine Learning</td>
                                <td class="text-center">3</td>
                                <td class="text-center"><span class="grade-badge grade-a">A</span></td>
                                <td class="text-center">12</td>
                                <td><span class="semester-badge">Semester 5</span></td>
                            </tr>
                            <tr data-semester="5">
                                <td><span class="code-badge">MI502</span></td>
                                <td>Big Data Analytics</td>
                                <td class="text-center">3</td>
                                <td class="text-center"><span class="grade-badge grade-ab">AB</span></td>
                                <td class="text-center">10.5</td>
                                <td><span class="semester-badge">Semester 5</span></td>
                            </tr>
                            <tr data-semester="5">
                                <td><span class="code-badge">MI503</span></td>
                                <td>Cloud Computing</td>
                                <td class="text-center">3</td>
                                <td class="text-center"><span class="grade-badge grade-a">A</span></td>
                                <td class="text-center">12</td>
                                <td><span class="semester-badge">Semester 5</span></td>
                            </tr>
                            <tr data-semester="4">
                                <td><span class="code-badge">MI401</span></td>
                                <td>Database Administration</td>
                                <td class="text-center">3</td>
                                <td class="text-center"><span class="grade-badge grade-a">A</span></td>
                                <td class="text-center">12</td>
                                <td><span class="semester-badge">Semester 4</span></td>
                            </tr>
                            <tr data-semester="4">
                                <td><span class="code-badge">MI402</span></td>
                                <td>Network Security</td>
                                <td class="text-center">3</td>
                                <td class="text-center"><span class="grade-badge grade-b">B</span></td>
                                <td class="text-center">9</td>
                                <td><span class="semester-badge">Semester 4</span></td>
                            </tr>
                            <tr data-semester="4">
                                <td><span class="code-badge">MI403</span></td>
                                <td>Mobile Programming</td>
                                <td class="text-center">3</td>
                                <td class="text-center"><span class="grade-badge grade-ab">AB</span></td>
                                <td class="text-center">10.5</td>
                                <td><span class="semester-badge">Semester 4</span></td>
                            </tr>
                            <tr data-semester="3">
                                <td><span class="code-badge">MI301</span></td>
                                <td>Web Development</td>
                                <td class="text-center">4</td>
                                <td class="text-center"><span class="grade-badge grade-a">A</span></td>
                                <td class="text-center">16</td>
                                <td><span class="semester-badge">Semester 3</span></td>
                            </tr>
                            <tr data-semester="3">
                                <td><span class="code-badge">MI302</span></td>
                                <td>Object Oriented Programming</td>
                                <td class="text-center">3</td>
                                <td class="text-center"><span class="grade-badge grade-ab">AB</span></td>
                                <td class="text-center">10.5</td>
                                <td><span class="semester-badge">Semester 3</span></td>
                            </tr>
                            <tr data-semester="2">
                                <td><span class="code-badge">MI201</span></td>
                                <td>Data Structures</td>
                                <td class="text-center">3</td>
                                <td class="text-center"><span class="grade-badge grade-b">B</span></td>
                                <td class="text-center">9</td>
                                <td><span class="semester-badge">Semester 2</span></td>
                            </tr>
                            <tr data-semester="1">
                                <td><span class="code-badge">MI101</span></td>
                                <td>Introduction to IT</td>
                                <td class="text-center">3</td>
                                <td class="text-center"><span class="grade-badge grade-a">A</span></td>
                                <td class="text-center">12</td>
                                <td><span class="semester-badge">Semester 1</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="transcript-summary">
                    <div class="summary-item">
                        <span>Total SKS</span>
                        <strong>96</strong>
                    </div>
                    <div class="summary-item">
                        <span>Total Bobot</span>
                        <strong>354</strong>
                    </div>
                    <div class="summary-item highlight">
                        <span>IPK Kumulatif</span>
                        <strong>3.72</strong>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Internship Section -->
    <section class="internship-section" id="magang">
        <div class="container-fluid px-3 px-lg-4">
            <div class="section-header">
                <h5><i class="fas fa-briefcase"></i> Riwayat Magang</h5>
            </div>
            <div class="row">

                @forelse($riwayatMagang as $item)
                    <div class="col-lg-6 mb-4">
                        <div class="internship-card {{ $item->status == 'aktif' ? 'current' : '' }}">

                            <div class="internship-status-badge">
                                <i class="fas fa-clock"></i> 
                                {{ $item->status == 'aktif' ? 'Sedang Berlangsung' : 'Selesai' }}
                            </div>

                            <h5 class="internship-title">{{ $item->posisi }}</h5>
                            <h6 class="internship-company">{{ $item->perusahaan->nama_perusahaan }}</h6>

                            <div class="internship-meta">
                                <span>
                                    <i class="fas fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($item->tgl_mulai)->format('M Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($item->tgl_selesai)->format('M Y') }}
                                </span>
                            </div>

                            <a href="#" class="btn-internship-detail">
                                Lihat Detail <i class="fas fa-arrow-right"></i>
                            </a>

                        </div>
                    </div>
                @empty
                    <div class="col-lg-12 mb-4">
                        <div class="internship-card empty">

                            <div class="empty-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>

                            <h5 class="internship-title">Belum ada riwayat magang</h5>

                            <p class="internship-desc">
                                Kamu belum memiliki riwayat magang.
                                Data akan muncul setelah mengikuti program magang dari kampus.
                            </p>

                        </div>
                    </div>
                @endforelse


                {{-- <div class="col-lg-6 mb-4">
                    <div class="internship-card current">
                        <div class="internship-status-badge"><i class="fas fa-clock"></i> Sedang Berlangsung</div>
                        <div class="internship-company-logo">
                            <img src="http://static.photos/technology/200x200/77" alt="PT. Digital Nusantara">
                        </div>
                        <h5 class="internship-title">Frontend Developer Intern</h5>
                        <h6 class="internship-company">PT. Digital Nusantara</h6>
                        <div class="internship-meta">
                            <span><i class="fas fa-map-marker-alt"></i> Serang, Banten</span>
                            <span><i class="fas fa-calendar"></i> Sep 2024 - Feb 2025</span>
                        </div>
                        <div class="internship-progress">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Progress Magang</span>
                                <span>65%</span>
                            </div>
                            <div class="internship-progress-bar">
                                <div class="internship-progress-fill" style="width: 65%"></div>
                            </div>
                        </div>
                        <div class="internship-skills">
                            <span class="skill-tag">React.js</span>
                            <span class="skill-tag">TypeScript</span>
                            <span class="skill-tag">Tailwind CSS</span>
                            <span class="skill-tag">Git</span>
                        </div>
                        <a href="#" class="btn-internship-detail">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="internship-card completed">
                        <div class="internship-status-badge completed"><i class="fas fa-check-circle"></i> Selesai</div>
                        <div class="internship-company-logo">
                            <img src="http://static.photos/office/200x200/55" alt="CV. Maju Jaya">
                        </div>
                        <h5 class="internship-title">IT Support Intern</h5>
                        <h6 class="internship-company">CV. Maju Jaya</h6>
                        <div class="internship-meta">
                            <span><i class="fas fa-map-marker-alt"></i> Cilegon, Banten</span>
                            <span><i class="fas fa-calendar"></i> Jan - Jun 2024</span>
                        </div>
                        <div class="internship-progress">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Penilaian</span>
                                <span><strong>A</strong> (Sangat Memuaskan)</span>
                            </div>
                            <div class="internship-progress-bar">
                                <div class="internship-progress-fill completed" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="internship-skills">
                            <span class="skill-tag">Networking</span>
                            <span class="skill-tag">Troubleshooting</span>
                            <span class="skill-tag">Linux</span>
                        </div>
                        <a href="#" class="btn-internship-detail">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <!-- Notifications / Announcements -->
    {{-- <section class="notification-section" id="notifikasi">
        <div class="container-fluid px-3 px-lg-4">
            <div class="section-header">
                <h5><i class="fas fa-bell"></i> Pemberitahuan</h5>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="notification-card urgent">
                        <div class="notif-card-icon"><i class="fas fa-exclamation-circle"></i></div>
                        <div class="notif-card-content">
                            <span class="notif-card-type">Pembayaran</span>
                            <h6>Tagihan Belum Lunas!</h6>
                            <p>Anda masih memiliki sisa tagihan sebesar <strong>Rp 2.500.000</strong> untuk semester ganjil 2024/2025. Silakan lakukan pembayaran sebelum batas waktu.</p>
                            <div class="notif-card-meta">
                                <span class="time"><i class="fas fa-clock"></i> 2 jam lalu</span>
                                <a href="#pembayaran" class="btn-notif-action">Bayar Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="notification-card info">
                        <div class="notif-card-icon"><i class="fas fa-info-circle"></i></div>
                        <div class="notif-card-content">
                            <span class="notif-card-type">Akademik</span>
                            <h6>Pengumuman Nilai Semester 5</h6>
                            <p>Nilai akhir semester 5 sudah dipublikasikan. Silakan cek transkrip nilai Anda di menu Akademik.</p>
                            <div class="notif-card-meta">
                                <span class="time"><i class="fas fa-clock"></i> 3 hari lalu</span>
                                <a href="#transkrip" class="btn-notif-action">Lihat Nilai</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="notification-card success">
                        <div class="notif-card-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="notif-card-content">
                            <span class="notif-card-type">Magang</span>
                            <h6>Penempatan Magang Disetujui</h6>
                            <p>Selamat! Penempatan magang Anda di PT. Digital Nusantara telah disetujui. Silakan lengkapi dokumen persyaratan.</p>
                            <div class="notif-card-meta">
                                <span class="time"><i class="fas fa-clock"></i> 1 hari lalu</span>
                                <a href="#magang" class="btn-notif-action">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="notification-card general">
                        <div class="notif-card-icon"><i class="fas fa-bullhorn"></i></div>
                        <div class="notif-card-content">
                            <span class="notif-card-type">Pengumuman</span>
                            <h6>Pendaftaran UAS Semester Ganjil</h6>
                            <p>Pendaftaran Ujian Akhir Semester ganjil 2024/2025 dibuka mulai tanggal 20 Desember 2024.</p>
                            <div class="notif-card-meta">
                                <span class="time"><i class="fas fa-clock"></i> 1 minggu lalu</span>
                                <a href="#" class="btn-notif-action">Daftar Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection