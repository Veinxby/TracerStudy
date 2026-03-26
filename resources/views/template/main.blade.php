<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link rel="shortcut icon" href="{{ asset('img/logo.png')}}" type="image/x-icon">
    <title>@yield('title')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('modules/izitoast/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/fullcalendar/fullcalendar.min.css') }}">
    {{-- Datatables --}}
    <link rel="stylesheet" href="{{ asset('modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    @yield('style')
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                @include('components.topbar')
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    @include('components.sidebar')   
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; LP3I BANTEN 2026
                </div>
                <div class="footer-right">
                
                </div>
            </footer>
        </div>
    </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('modules/jquery.min.js')}}"></script>
  <script src="{{ asset('modules/popper.js')}}"></script>
  <script src="{{ asset('modules/tooltip.js')}}"></script>
  <script src="{{ asset('modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('modules/moment.min.js')}}"></script>
  <script src="{{ asset('js/stisla.js')}}"></script>
  
  <!-- JS Libraies -->
  {{-- Izitoast --}}
  <script src="{{ asset('modules/izitoast/js/iziToast.min.js')}}"></script>
  {{-- Full Calender --}}
  <script src="{{ asset('modules/fullcalendar/fullcalendar.min.js')}}"></script>
    {{-- Datatables --}}
    <script src="{{ asset('modules/datatables/datatables.min.js')}}"></script>
    <script src="{{ asset('modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{ asset('modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('modules/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('js/page/bootstrap-modal.js')}}"></script>
  <script src="{{ asset('js/page/index.js')}}"></script>

  
  <!-- Template JS File -->
  <script src="{{ asset('js/scripts.js')}}"></script>
  <script src="{{ asset('js/custom.js')}}"></script>
  <script>
    $(document).ready(function () {

        $('#btn-logout').on('click', function (e) {
            e.preventDefault();

            swal({
                title: "Yakin ingin logout?",
                text: "Sesi Anda akan berakhir.",
                icon: "warning",
                buttons: ["Batal", "Ya, Logout"],
                dangerMode: true,
            }).then((willLogout) => {

                if (willLogout) {

                    $.ajax({
                        url: "{{ route('logout') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function () {

                            swal({
                                title: "Berhasil!",
                                text: "Anda berhasil logout.",
                                icon: "success",
                                buttons: false,
                                timer: 1500
                            });

                            setTimeout(function () {
                                window.location.href = "{{ route('login') }}";
                            }, 1500);
                        },
                        error: function () {

                            swal({
                                title: "Gagal!",
                                text: "Logout gagal, silakan coba lagi.",
                                icon: "error",
                            });
                        }
                    });

                }

            });
        });

    });
  </script>
  @yield('script')
</body>
</html>