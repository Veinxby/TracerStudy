<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/logo/logo_oasis_bg_white.png')}}" type="image/x-icon">
    @yield('title')
    <title>OASIS - One Access Student Information System | LP3I Banten</title>
    <link rel="stylesheet" href="{{ asset('modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}">

    {{-- Datatables --}}
    <link rel="stylesheet" href="{{ asset('modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mhs/style.css') }}">
    @yield('style')
</head>
<body>
    <a href="#section1" class="smooth-scroll">

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-xl fixed-top oasis-navbar" id="mainNavbar">
        <div class="container-fluid px-3 px-lg-4">
            @include('components.mahasiswa.navbar')
        </div>
    </nav>

    <!-- ===== NOTIFICATION PANEL ===== -->
    <div class="notification-panel" id="notifPanel">
        <div class="notif-panel-header">
            <h6><i class="fas fa-bell"></i> Notifikasi</h6>
            <button class="btn-close-notif" onclick="toggleNotifPanel()"><i class="fas fa-times"></i></button>
        </div>
        <div class="notif-panel-body">
            <div class="notif-item unread">
                <div class="notif-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="notif-content">
                    <p>Tagihan semester ganjil <strong>Rp 2.500.000</strong> belum dibayar</p>
                    <span class="notif-time">2 jam lalu</span>
                </div>
            </div>
            <div class="notif-item unread">
                <div class="notif-icon bg-success"><i class="fas fa-check-circle"></i></div>
                <div class="notif-content">
                    <p>Magang di <strong>PT. Digital Nusantara</strong> telah disetujui</p>
                    <span class="notif-time">1 hari lalu</span>
                </div>
            </div>
            <div class="notif-item unread">
                <div class="notif-icon bg-info"><i class="fas fa-file-alt"></i></div>
                <div class="notif-content">
                    <p>Nilai semester genam sudah tersedia</p>
                    <span class="notif-time">3 hari lalu</span>
                </div>
            </div>
            <div class="notif-item">
                <div class="notif-icon bg-primary"><i class="fas fa-bullhorn"></i></div>
                <div class="notif-content">
                    <p>Pendaftaran ujian akhir semester dibuka</p>
                    <span class="notif-time">1 minggu lalu</span>
                </div>
            </div>
        </div>
        <div class="notif-panel-footer">
            <a href="#">Lihat Semua Notifikasi</a>
        </div>
    </div>

    <!-- ===== OVERLAY ===== -->
    <div class="overlay" id="overlay" onclick="closeAllPanels()"></div>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">

        @yield('content')

    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="oasis-footer">
        <div class="container-fluid px-3 px-lg-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="footer-brand">
                        <i class="fas fa-graduation-cap"></i>
                        <span>OASIS</span> — One Access Student Information System
                    </div>
                </div>
                <div class="col-md-6 text-md-right">
                    <span class="footer-copy">© 2026 LP3I Banten. All rights reserved.</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('modules/jquery.min.js')}}"></script>
    <script src="{{ asset('modules/popper.js')}}"></script>
    <script src="{{ asset('modules/bootstrap/js/bootstrap.min.js')}}"></script>

    <script src="{{ asset('modules/datatables/datatables.min.js')}}"></script>
    <script src="{{ asset('modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{ asset('modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('modules/select2/dist/js/select2.full.min.js')}}"></script>

    <script src="{{ asset('modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{ asset('mhs/script.js')}}"></script>
    
    @yield('script')
    @stack('script')
</body>
</html>