<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
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

  @stack('css-custom')

   <!-- Template Main CSS File -->
   <link href="{{ asset('themes/assets/css/style.css') }}" rel="stylesheet">

  
</head>

<body>

  <!-- ======= Header ======= -->
  @include('admin._layouts.header');
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('admin._layouts.sidebar');
  <!-- End Sidebar-->

  <main id="main" class="main">


    @yield('content')

  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('admin._layouts.footer');
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  

  <!-- Template Main JS File -->

  @stack('javascript-global')
  @stack('javascript-vendor')
  <script src="{{ asset('themes/assets/js/main.js') }}"></script>
  @stack('js')
</body>


</html>