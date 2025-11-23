<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="{{ auth()->check() ? route('redirect') : url('/') }}" class="logo d-flex align-items-center">
      <img src="{{ asset('assets/img/logo-dashboard.png') }}" alt="">
      <span class="d-none d-lg-block">simtu</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <!-- Search Bar -->
  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
  </div><!-- End Search Bar -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <!-- Search Icon (mobile) -->
      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle " href="#">
          <i class="bi bi-search"></i>
        </a>
      </li>

      <!-- 🔥 NOTIFICATION BELL LIVEWIRE - HIDDEN UNTUK ADMIN -->
      @if(auth()->check() && auth()->user()->role !== 'admin')
        @livewire('shared.notification-bell')
      @endif

      <!-- 🔥 MESSAGE DROPDOWN DIHAPUS -->

      <!-- Profile Dropdown with Logout -->
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name ?? 'User' }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{ auth()->user()->name ?? 'User' }}</h6>
            <span>{{ ucfirst(auth()->user()->role ?? 'guest') }}</span>
          </li>
          <li><hr class="dropdown-divider"></li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route(auth()->user()->role . '.profil') }}">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          
          <!-- 🔥 LINK NOTIFIKASI DI PROFILE DROPDOWN - HIDE UNTUK ADMIN -->
          @if(auth()->user()->role !== 'admin')
            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route(auth()->user()->role . '.notifikasi') }}">
                    <i class="bi bi-bell"></i>
                    <span>Notifikasi</span>
                </a>
            </li>
          @endif
          
          <li><hr class="dropdown-divider"></li>

          <!-- 🔥 ACCOUNT SETTINGS & NEED HELP DIHAPUS -->

          <!-- ✅ Logout Button -->
          <li>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
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