<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>FDR Hans Motor</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('themes/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('themes/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  {{-- <link href="https://fonts.gstatic.com" rel="preconnect"> --}}
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  @stack('css-vendor')

  <!-- Template Main CSS File -->
  <link href="{{ asset('themes/assets/css/style.css') }}" rel="stylesheet">

  @stack('css-custom')

  


</head>

<body>

  <!-- ======= Header ======= -->
  @include('admin._layouts.header');
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('admin._layouts.sidebar');
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @yield('content')

  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('admin._layouts.footer');
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  

  <!-- Template Main JS File -->
  <script src="{{ asset('themes/assets/js/main.js') }}"></script>

  @stack('javascript-global')
  @stack('javascript-vendor')
</body>

</html>