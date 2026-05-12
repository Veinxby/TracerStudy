<!-- Logo & Brand -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div class="brand-logo">
                    <div class="logo-icon">
                        <img src="{{ asset('img/logo/logo_oasis.png')}}" alt="">
                    </div>
                </div>
                <div class="brand-text ml-2">
                    <span class="brand-name">OASIS</span>
                    <span class="brand-sub">LP3I Banten</span>
                </div>
            </a>

            <!-- Mobile Toggle -->
            <div class="d-flex align-items-center order-xl-last ml-auto">

                <!-- Notification Bell Mobile -->
                <div class="nav-notification-btn d-xl-none mr-2" onclick="toggleMobileNotif()">
                    <i class="fas fa-bell"></i>
                    <span class="notif-badge">3</span>
                </div>

                <!-- Profile Mobile -->
                <div class="nav-profile-mobile d-xl-none mr-2" onclick="toggleMobileProfile()">
                    @if(!empty($foto))
                        <img src="{{ asset('storage/' . $foto) }}" alt="Profile">
                    @else
                        <i class="fas fa-user-graduate"></i>
                    @endif
                </div>

                    <div class="profile-dropdown" id="profileDropdownMobile">
                        <div class="profile-dropdown-header">
                            @if(!empty($foto))
                                <img src="{{ asset('storage/' . $foto) }}" alt="Profile">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            @endif
                            <div>
                                <h6>{{$nama}}</h6>
                                <span>{{ !empty($email) ? $email : 'email not added!' }}</span>
                            </div>
                        </div>
                        <div class="profile-dropdown-body">
                            <a href="{{ url('/mhs/profile') }}" class="profile-menu-item">
                                <i class="fas fa-user"></i>
                                <span>Profil Saya</span>
                            </a>
                            <a href="#" class="profile-menu-item">
                                <i class="fas fa-cog"></i>
                                <span>Pengaturan</span>
                            </a>
                            <a href="#" class="profile-menu-item">
                                <i class="fas fa-question-circle"></i>
                                <span>Pusat Bantuan</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="profile-menu-item logout-item">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </a>
                        </div>
                    </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain">
                    <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                </button>

            </div>

            <!-- Nav Links -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#dashboard">
                            <i class="fas fa-th-large nav-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown mega-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-graduate nav-icon"></i>
                            <span>Akademik</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <div class="dropdown-menu mega-menu">
                            <div class="mega-menu-inner">
                                <div class="mega-col">
                                    <h6 class="mega-title"><i class="fas fa-book"></i> Perkuliahan</h6>
                                    <a class="dropdown-item" href="#transkrip"><i class="fas fa-file-alt"></i> Transkrip Nilai</a>
                                    <a class="dropdown-item" href="#krs"><i class="fas fa-clipboard-list"></i> KRS Semester</a>
                                    <a class="dropdown-item" href="#jadwal"><i class="fas fa-calendar-alt"></i> Jadwal Kuliah</a>
                                    <a class="dropdown-item" href="#kehadiran"><i class="fas fa-user-check"></i> Kehadiran</a>
                                </div>
                                <div class="mega-col">
                                    <h6 class="mega-title"><i class="fas fa-award"></i> Prestasi</h6>
                                    <a class="dropdown-item" href="#"><i class="fas fa-trophy"></i> Penghargaan</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-certificate"></i> Sertifikasi</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-medal"></i> Kompetisi</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown mega-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-wallet nav-icon"></i>
                            <span>Keuangan</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <div class="dropdown-menu mega-menu">
                            <div class="mega-menu-inner">
                                <div class="mega-col">
                                    <h6 class="mega-title"><i class="fas fa-money-bill-wave"></i> Pembayaran</h6>
                                    <a class="dropdown-item" href="#pembayaran"><i class="fas fa-credit-card"></i> Tagihan & Bayar</a>
                                    <a class="dropdown-item" href="#riwayat-bayar"><i class="fas fa-history"></i> Riwayat Bayar</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-receipt"></i> Kwitansi</a>
                                </div>
                                <div class="mega-col">
                                    <h6 class="mega-title"><i class="fas fa-info-circle"></i> Informasi</h6>
                                    <a class="dropdown-item" href="#"><i class="fas fa-hand-holding-usd"></i> Beasiswa</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-question-circle"></i> Bantuan Keuangan</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown mega-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-briefcase nav-icon"></i>
                            <span>Magang</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </a>
                        <div class="dropdown-menu mega-menu">
                            <div class="mega-menu-inner">
                                <div class="mega-col">
                                    <h6 class="mega-title"><i class="fas fa-building"></i> Penempatan</h6>
                                    <a class="dropdown-item" href="#magang"><i class="fas fa-map-marker-alt"></i> Riwayat Magang</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-search-location"></i> Cari Perusahaan</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-file-signature"></i> Laporan Magang</a>
                                </div>
                                <div class="mega-col">
                                    <h6 class="mega-title"><i class="fas fa-star"></i> Evaluasi</h6>
                                    <a class="dropdown-item" href="#"><i class="fas fa-chart-line"></i> Penilaian</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-comments"></i> Feedback</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                <!-- Profile Section Desktop -->
                <div class="nav-profile-section d-none d-xl-flex align-items-center">

                    <div class="nav-notification" onclick="toggleNotifPanel()">
                        <i class="fas fa-bell"></i>
                        <span class="notif-badge">3</span>
                    </div>

                    <div class="nav-profile" onclick="toggleProfileMenu()">
                        <div class="profile-info">
                            <span class="profile-name">{{$nama}}</span>
                            <span class="profile-role">
                               {{$kode_jurusan}}{{ $kodeKelas }} • {{ $tahunMasuk }}
                            </span>
                        </div>
                        <div class="profile-avatar">
                            @if(!empty($foto))
                                <img src="{{ asset('storage/' . $foto) }}" alt="Profile">
                            @else
                                <i class="fas fa-user-graduate"></i>
                            @endif
                            {{-- <span class="online-dot"></span> --}}
                        </div>
                        <i class="fas fa-chevron-down profile-arrow" id="profileArrow"></i>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="profile-dropdown" id="profileDropdownDesktop">
                        <div class="profile-dropdown-header">
                            @if(!empty($foto))
                                <img src="{{ asset('storage/' . $foto) }}" alt="Profile">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            @endif
                            <div>
                                <h6>{{$nama}}</h6>
                                <span>{{ !empty($email) ? $email : 'email not added!' }}</span>
                            </div>
                        </div>
                        <div class="profile-dropdown-body">
                            <a href="{{ url('/mhs/profile') }}" class="profile-menu-item">
                                <i class="fas fa-user"></i>
                                <span>Profil Saya</span>
                            </a>
                            <a href="#" class="profile-menu-item">
                                <i class="fas fa-cog"></i>
                                <span>Pengaturan</span>
                            </a>
                            <a href="#" class="profile-menu-item">
                                <i class="fas fa-question-circle"></i>
                                <span>Pusat Bantuan</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="profile-menu-item logout-item">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>