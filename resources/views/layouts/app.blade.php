<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard') | SIMTU IDN</title>

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  
  <!-- ApexCharts CSS dari CDN -->
  <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.0/dist/apexcharts.css" rel="stylesheet">
  
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  @livewireStyles

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <!-- ======= Header ======= -->
  @include('partials.header')

  <!-- ======= Sidebar ======= -->
  @php
      $role = auth()->user()->role ?? null;
  @endphp

  @if ($role === 'admin')
      @include('partials.sidebar-admin')
  @elseif ($role === 'koordinator')
      @include('partials.sidebar-koordinator')
  @elseif ($role === 'mahasiswa')
      @include('partials.sidebar-mahasiswa')
  @endif

  <main id="main" class="main">
    {{ $slot }}
  </main>

  <!-- ======= Footer ======= -->
  @include('partials.footer')

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  @livewireScripts
  <!-- ApexCharts JS dari CDN -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.35.0/dist/apexcharts.min.js"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
  
  <!-- Global SweetAlert2 Handler - SIMPLIFIED VERSION -->
  <!-- Global SweetAlert2 Handler - SIMPLIFIED VERSION -->
    <script>
        // Success notification - global
        Livewire.on('showSuccess', (event) => {
            Swal.fire({
                icon: 'success',
                title: event.title || 'Berhasil!',
                text: event.message,
                timer: event.timer || 3000,
                showConfirmButton: event.showConfirmButton || false
            });
        });

        // Error notification - global
        Livewire.on('showError', (event) => {
            Swal.fire({
                icon: 'error',
                title: event.title || 'Error!',
                text: event.message,
                timer: event.timer || 4000
            });
        });

        // Warning notification - global
        Livewire.on('showWarning', (event) => {
            Swal.fire({
                icon: 'warning',
                title: event.title || 'Peringatan!',
                text: event.message,
                timer: event.timer || 4000
            });
        });

        // Info notification - global 
        Livewire.on('showInfo', (event) => {
            Swal.fire({
                icon: 'info',
                title: event.title || 'Informasi',
                text: event.message,
                timer: event.timer || 3000,
                showConfirmButton: false
            });
        });

        // Delete confirmation - SIMPLIFIED VERSION
        Livewire.on('showDeleteConfirmation', (event) => {
            Swal.fire({
                title: event.title || 'Hapus Data?',
                text: event.text || "Anda tidak dapat mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: event.confirmText || 'Ya, Hapus!',
                cancelButtonText: event.cancelText || 'Batal',
                reverseButtons: true,
                focusCancel: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteConfirmed');
                }
            });
        });

        // General confirmation - SIMPLIFIED VERSION
        Livewire.on('showConfirmation', (event) => {
            Swal.fire({
                title: event.title || 'Konfirmasi',
                text: event.text,
                icon: event.icon || 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: event.confirmText || 'Ya',
                cancelButtonText: event.cancelText || 'Batal',
                reverseButtons: true,
                focusCancel: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('actionConfirmed', { 
                        callback: event.callback,
                        params: event.params 
                    });
                }
            });
        });
    </script>

  @stack('scripts')
</body>
</html>