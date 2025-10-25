<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title ?? 'Dashboard' }} - Simtu IDN</title>

  <!-- NiceAdmin CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

  @livewireStyles
</head>
<body>

  <!-- include header (optional) -->
  @if (View::exists('layouts.partials.header'))
    @include('layouts.partials.header')
  @endif

  <!-- include sidebar (optional) -->
  @if (View::exists('layouts.partials.sidebar'))
    @include('layouts.partials.sidebar')
  @endif

  <main id="main" class="main">
    @yield('content')
  </main>

  <!-- NiceAdmin JS (load BEFORE Livewire scripts as you planned) -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>

  @livewireScripts
</body>
</html>
