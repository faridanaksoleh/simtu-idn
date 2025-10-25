<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard') | SIMTU IDN</title>

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  @livewireStyles
</head>

<body>

  <!-- ======= Header ======= -->
  @include('partials.header')

  <!-- ======= Sidebar ======= -->
  @include('partials.sidebar')

  <main id="main" class="main">
    @yield('content')
  </main>

  <!-- ======= Footer ======= -->
  @include('partials.footer')

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
  @livewireScripts
</body>
</html>
