<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tracer Study</title>
    <link rel="shortcut icon" href="{{ asset('img/logo (2).png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Nunito', sans-serif;
        }

        body {
            background-color: #f4f6f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            padding: 70px 20px 40px 20px; /* Padding atas besar agar card agak ke bawah */
        }

        /* Logo & Nama Aplikasi di Pojok Kiri Atas */
        .header-brand {
            position: absolute;
            top: 10px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 10;
        }

        .header-brand img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .header-brand span {
            font-size: 20px;
            font-weight: 100;
            color: #22295d;
            letter-spacing: 0.5px;
        }

        /* --- STYLE NOTIFIKASI BARU --- */
        .alert {
            padding: 12px 40px 12px 16px; /* Ruang lebih di kanan untuk tombol X */
            border-radius: 6px;
            margin-bottom: 25px;
            font-size: 14px;
            position: relative; /* Penting untuk posisi tombol close */
            display: flex;
            align-items: center;
            border: 1px solid transparent;
            border-left-width: 5px;
            transition: opacity 0.3s ease;
        }
        
        /* Notif Gagal (Merah) */
        .alert-danger {
            background-color: #fff5f5;
            color: #c53030;
            border-color: #fed7d7;
            border-left-color: #fc544b;
        }

        .btn-close {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: inherit;
            font-size: 18px;
            font-weight: bold;
            line-height: 1;
            cursor: pointer;
            opacity: 0.5;
            padding: 5px;
        }

        .btn-close:hover { opacity: 1; }

        /* Notif Sukses (Hijau) */
        .alert-success {
            background-color: #f0fff4;
            color: #276749;
            border-left-color: #47c363;
            border: 1px solid #c6f6d5;
            border-left-width: 5px;
        }
        /* ----------------------------- */

        .login-container {
            width: 100%;
            max-width: 500px; /* Card diperlebar */
            display: flex;
            flex-direction: column;
        }

        .login-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border-top: 5px solid #6777ef;
            padding: 30px;
        }

        .login-card h4 {
            color: #6777ef;
            text-align: center;
            font-size: 38px;
            margin-bottom: 5px; /* Jarak ke teks deskripsi */
            font-weight: 700;
        }

        .login-card p.subtitle {
            text-align: center;
            color: #98a6ad;
            font-size: 12px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #34395e;
            margin-bottom: 10px;
        }

        .label-flex {
            display: flex;
            justify-content: space-between;
        }

        .forgot-password {
            font-size: 13px;
            color: #6777ef;
            text-decoration: none;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #e4e6fc;
            background-color: #fdfdff;
            border-radius: 6px;
            outline: none;
            font-size: 15px;
        }
        .password-group{
            position: relative;
        }

        .toggle-password{
            position:absolute;
            right:15px;
            top:40px;
            cursor:pointer;
            color:#6777ef;
            font-size:16px;
        }

        .form-control:focus {
            border-color: #6777ef;
            background-color: #fff;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #868ba1;
            margin-bottom: 30px;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            background-color: #6777ef;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(103, 119, 239, 0.3);
        }

        /* Footer Section: Jarak dirapatkan */
        .footer-section {
            text-align: center;
            margin-top: 20px;
        }

        .footer-text {
            font-size: 15px;
            color: #868ba1;
            margin-bottom: 10px;
        }

        .footer-text a {
            color: #6777ef;
            text-decoration: none;
            font-weight: 600;
        }

        .copyright {
            font-size: 13px;
            color: #98a6ad;
            margin-bottom: 20px;
        }

        /* Perbaikan untuk layar kecil agar tidak menabrak logo */
        @media (max-width: 768px) {
            .header-brand {
                position: relative;
                top: 0;
                left: 0;
                margin-bottom: 40px;
                justify-content: center;
            }
            body {
                padding-top: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="header-brand">
        <img src="{{ asset('img/logo (2).png') }}" alt="Logo"> 
        <span>Tracer Study | LP3I Banten</span>
    </div>
    <div class="login-container">
        <div class="login-card">
            <h4 >Login</h4>
            <p class="subtitle">Silahkan masuk menggunakan akun anda untuk melacak data alumni dan perkembangan karir.</p>

            @if(session('throttle'))
                <div class="alert alert-danger" id="throttleAlert">
                    <strong>⚠️ Too Many Attempts.</strong>
                   Try again in 
                    <span id="countdown">{{ session('retry_after') }}</span> detik.
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger" id="loginAlert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" onclick="closeAlert()">&times;</button>
                </div>
            @endif


            @if(session('success'))
                <div class="alert alert-success" id="loginAlert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" onclick="closeAlert()">&times;</button>
                </div>
            @endif
            
            
            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="form-group">
                    <label for="login">NIPD / Email</label>
                    <input type="text" id="login" name="login" class="form-control login-input" placeholder="Masukkan NIPD atau email anda" value="{{ old('login') }}" required>
                </div>

                <div class="form-group password-group">

                    <label>Password</label>

                    <input type="password"
                            id="password"
                            name="password"
                            class="form-control pass-input"
                            placeholder="Masukkan password"
                            required>

                    <span class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </span>

                </div>

                <label class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <span>Ingat Sesi Saya</span>
                </label>

                <button type="submit" class="btn-login">Masuk ke Sistem</button>
            </form>
        </div>

        <div class="footer-section">
            <p class="footer-text">
                Belum punya akun? <a href="#">Daftar Sekarang</a>
            </p>
            <p class="copyright">
                Copyright &copy; LP3I BANTEN 2026
            </p>
        </div>
    </div>


    <script src="{{ asset('modules/jquery.min.js')}}"></script>
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js')}}"></script>
    <script>
        $(document).ready(function(){

            @if(session('success'))

                swal({
                    title: "Login Berhasil",
                    text: "{{ session('success') }}",
                    icon: "success",
                    buttons: false,
                    timer: 1500
                });

                setTimeout(function(){
                    window.location.href = "{{ session('redirect') }}";
                },1500);

            @endif


            @if(session('error'))

                swal({
                    title: "Login Gagal",
                    text: "{{ session('error') }}",
                    icon: "error",
                });

            @endif

            @if(session('throttle'))
                <div style="position: fixed; bottom:20px; right:20px; z-index:9999;">

                    <div class="toast show" id="throttleToast">

                        <div class="toast-header bg-danger text-white">
                            <strong class="mr-auto">Terlalu Banyak Percobaan</strong>
                        </div>

                        <div class="toast-body">
                            Silahkan coba lagi dalam
                            <strong id="countdown">{{ session('retry_after') }}</strong>
                            detik
                        </div>

                    </div>

                </div>
            @endif


            let seconds = parseInt($('#countdown').text());

            if(!seconds) return;

            const btn = $('.btn-login');
            const inputs = $('.login-input, .pass-input');

            btn.prop('disabled', true);
            inputs.prop('disabled', true);

            let timer = setInterval(function(){

                seconds--;
                $('#countdown').text(seconds);

                if(seconds <= 0){

                    clearInterval(timer);

                    btn.prop('disabled', false);
                    inputs.prop('disabled', false);

                    $('#throttleToast').remove();

                }

            },1000);


            
        });
        // Hide Unhide Password
        $(document).on('click','.toggle-password',function(){

            let input = $('#password');
            let icon = $(this).find('i');

            if(input.attr('type') === 'password'){
                input.attr('type','text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            }else{
                input.attr('type','password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }

        });

        // function closeAlert() {
        //     const alert = document.getElementById('loginAlert');
        //     alert.style.display = 'none';
        // }

        // document.addEventListener('DOMContentLoaded', function () {
        //     const countdownEl = document.getElementById('countdown');
        //     if (!countdownEl) return;

        //     let seconds = parseInt(countdownEl.innerText);
        //     const btn = document.querySelector('.btn-login');
        //     const inputs = document.querySelectorAll('.login-input');
        //     const pass = document.querySelectorAll('.pass-input');

        //     btn.disabled = true;
        //     inputs.forEach(i => i.disabled = true);
        //     pass.forEach(i => i.disabled = true);

        //     const timer = setInterval(() => {
        //         seconds--;
        //         countdownEl.innerText = seconds;

        //         if (seconds <= 0) {
        //             clearInterval(timer);
        //             btn.disabled = false;
        //             inputs.forEach(i => i.disabled = false);
        //             pass.forEach(i => i.disabled = false);

        //             document.getElementById('throttleAlert').remove();
        //         }
        //     }, 1000);
        // });
    </script>

</body>
</html>