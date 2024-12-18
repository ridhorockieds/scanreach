<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
  <style>
    /* Container utama */
    .error-container {
        display: flex; /* Mengaktifkan Flexbox */
        flex-direction: column; /* Elemen ditumpuk secara vertikal */
        align-items: center; /* Pusatkan secara horizontal */
        justify-content: center; /* Pusatkan secara vertikal */
        height: 100vh; /* Tinggi penuh layar */
        text-align: center; /* Teks rata tengah */
    }

    /* Styling untuk kode error */
    .error-code {
        font-size: 8rem; /* Ukuran font besar */
        color: #e63946; /* Warna merah */
        margin: 0; /* Hilangkan margin default */
    }

    /* Styling untuk pesan error */
    .error-message p {
        font-size: 1.5rem; /* Ukuran font sedang */
        margin: 0.5rem 0; /* Spasi atas dan bawah */
    }

    /* Link styling */
    .return-link {
        color: #1d4ed8; /* Warna biru */
        text-decoration: none; /* Hilangkan garis bawah */
        font-weight: bold; /* Teks tebal */
        font-size: 1.2rem;
    }

    .return-link:hover {
        text-decoration: underline; /* Tambahkan garis bawah saat hover */
    }

  </style>
</head>
<body class="hold-transition sidebar-mini">
    <!-- Main content -->
    <section class="content">
        <div class="error-container">
            <h1 class="error-code">@yield('code')</h1>
            <div class="error-message">
                @yield('message')
                <a href="/dashboard" class="return-link">return to dashboard</a>
            </div>
        </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
</body>
</html>
