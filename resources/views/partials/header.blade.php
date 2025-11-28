<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center bg-white shadow-sm border-bottom">

  <div class="d-flex align-items-center justify-content-between">
    <a href="{{ auth()->check() ? route('redirect') : url('/') }}" class="logo d-flex align-items-center">
      <img src="{{ asset('assets/img/logo-dashboard.png') }}" alt="">
      <span class="d-none d-lg-block ms-2 fw-bold text-dark">simtu</span>
    </a>
    <!-- 🔥 PERBAIKAN: Hanya tampilkan hamburger menu di mobile -->
    <i class="bi bi-list toggle-sidebar-btn d-block d-lg-none"></i>
  </div><!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <!-- 🔥 NOTIFICATION BELL LIVEWIRE - HIDDEN UNTUK ADMIN -->
      @if(auth()->check() && auth()->user()->role !== 'admin')
        @livewire('shared.notification-bell')
      @endif

      <!-- Profile Dropdown with Logout -->
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <!-- 🔥 PERBAIKAN: Foto profil dari user -->
          @if(auth()->user()->profile_photo_path)
            <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="Profile" class="rounded-circle" width="32" height="32" style="object-fit: cover;">
          @elseif(auth()->user()->avatar)
            <img src="{{ auth()->user()->avatar }}" alt="Profile" class="rounded-circle" width="32" height="32" style="object-fit: cover;">
          @else
            <!-- Fallback ke default avatar atau initial -->
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px; font-weight: bold;">
              {{ substr(auth()->user()->name, 0, 1) }}
            </div>
          @endif
          <span class="d-none d-md-block dropdown-toggle ps-2 text-dark fw-medium">{{ auth()->user()->name ?? 'User' }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile shadow border-0">
          <li class="dropdown-header">
            <!-- 🔥 PERBAIKAN: Foto profil di dropdown header juga -->
            <div class="d-flex align-items-center">
              @if(auth()->user()->profile_photo_path)
                <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="Profile" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
              @elseif(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" alt="Profile" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
              @else
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">
                  {{ substr(auth()->user()->name, 0, 1) }}
                </div>
              @endif
              <div>
                <h6 class="fw-bold mb-0">{{ auth()->user()->name ?? 'User' }}</h6>
                <span class="text-muted text-capitalize">{{ auth()->user()->role ?? 'guest' }}</span>
              </div>
            </div>
          </li>
          <li><hr class="dropdown-divider m-0"></li>

          <li>
            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route(auth()->user()->role . '.profil') }}">
              <i class="bi bi-person me-2"></i>
              <span>My Profile</span>
            </a>
          </li>
          
          <!-- 🔥 LINK NOTIFIKASI DI PROFILE DROPDOWN - HIDE UNTUK ADMIN -->
          @if(auth()->user()->role !== 'admin')
            <li>
                <a class="dropdown-item d-flex align-items-center py-2" href="{{ route(auth()->user()->role . '.notifikasi') }}">
                    <i class="bi bi-bell me-2"></i>
                    <span>Notifikasi</span>
                </a>
            </li>
          @endif
          
          <li><hr class="dropdown-divider m-0"></li>

          <!-- ✅ Logout Button -->
          <li>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center py-2 text-danger">
                <i class="bi bi-box-arrow-right me-2"></i>
                <span>Logout</span>
              </button>
            </form>
          </li>
        </ul>
      </li><!-- End Profile Dropdown -->
    </ul>
  </nav><!-- End Icons Navigation -->

</header><!-- End Header -->