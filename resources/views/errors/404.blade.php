<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page | Tracer Study LP3I Banten</title>
    
    <link rel="shortcut icon" href="{{ asset('img/logo (2).png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --lp3i-blue: #004a99;
            --lp3i-orange: #ff6600;
            --bg-canvas: #f4f7fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-canvas);
            /* Background Pattern Halus */
            background-image: radial-gradient(#d1d5db 0.5px, transparent 0.5px);
            background-size: 20px 20px;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Container Utama Center */
        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-card {
            background: #ffffff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            text-align: center;
            transition: transform 0.3s ease;
        }

        /* Bagian Logo Atas */
        .card-header-logo {
            padding: 30px 20px 10px;
        }

        .logo-img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .brand-name {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--lp3i-blue);
            letter-spacing: 1px;
            margin-top: 10px;
            text-transform: uppercase;
        }

        /* Angka Error */
        .error-code-wrapper {
            padding: 20px 0;
        }

        .error-code {
            font-size: 100px;
            font-weight: 800;
            color: #2d3436;
            line-height: 1;
            margin: 0;
            position: relative;
            display: inline-block;
        }

        /* Garis dekoratif bawah angka */
        .error-code::after {
            content: '';
            display: block;
            width: 50px;
            height: 6px;
            background: var(--lp3i-orange);
            margin: 10px auto 0;
            border-radius: 10px;
        }

        .card-body {
            padding: 0 40px 40px;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 12px;
        }

        .error-text {
            font-size: 0.95rem;
            color: #636e72;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Tombol Custom */
        .btn-lp3i {
            background-color: var(--lp3i-blue);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-lp3i:hover {
            background-color: #003366;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 74, 153, 0.3);
        }

        .btn-back {
            background-color: #f1f2f6;
            color: #57606f;
            margin-top: 10px;
        }

        .btn-back:hover {
            background-color: #dfe4ea;
            color: #2f3542;
        }

        /* Footer */
        .footer-text {
            padding: 20px;
            font-size: 0.8rem;
            color: #a0a0a0;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .error-card { border-radius: 0; box-shadow: none; background: transparent; }
            .card-body { padding: 0 20px 20px; }
            .error-code { font-size: 80px; }
        }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <div class="error-card">
            <div class="card-header-logo">
                <img src="{{ asset('img/logo (2).png') }}" alt="LP3I Logo" class="logo-img">
                <span class="brand-name">Tracer Study | LP3I Banten</span>
            </div>

            <div class="error-code-wrapper">
                <h1 class="error-code">404</h1>
            </div>

            <div class="card-body">
                <h2 class="error-title">Halaman Tidak Ditemukan</h2>
                <p class="error-text">
                    Maaf, tautan yang Anda tuju mungkin salah atau telah dihapus oleh sistem. Silakan kembali ke dashboard.
                </p>

                <a href="{{ route('admin.dashboard') }}" class="btn-lp3i">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
                <a href="https://wa.me/your-number" class="btn-lp3i btn-back">
                    <i class="fas fa-headset"></i> Hubungi Admin
                </a>
            </div>
        </div>
    </div>

    <div class="footer-text">
        &copy; 2024 Politeknik LP3I - Kampus Banten. <br>
        Sistem Informasi Tracer Study v2.0
    </div>

</body>
</html>