<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? '' : 'collapsed' }}" href="{{ route('mahasiswa.dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-heading">Tabungan Saya</li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('mahasiswa.target-tabungan') ? '' : 'collapsed' }}" href="{{ route('mahasiswa.target-tabungan') }}">
        <i class="bi bi-coin"></i> <!-- icon yang cocok sama menu targer tabungan -->
        <span>Target Tabungan</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('mahasiswa.transaksi') ? '' : 'collapsed' }}" href="{{ route('mahasiswa.transaksi') }}">
        <i class="bi bi-credit-card-2-front"></i> <!-- icon yang cocok sama menu transaksi -->
        <span>Transaksi</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('mahasiswa.konsultasi') ? '' : 'collapsed' }}" href="{{ route('mahasiswa.konsultasi') }}">
        <i class="bi bi-chat-left-dots"></i>
        <span>Konsultasi</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('mahasiswa.notifikasi') ? '' : 'collapsed' }}" href="{{ route('mahasiswa.notifikasi') }}">
        <i class="bi bi-bell"></i>
        <span>Notifikasi</span>
      </a>
    </li>

    <li class="nav-heading">Akun</li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('mahasiswa.profil') ? '' : 'collapsed' }}" href="{{ route('mahasiswa.profil') }}">
        <i class="bi bi-person"></i>
        <span>Profil</span>
      </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="nav-link btn w-100 text-start text-danger">
          <i class="bi bi-box-arrow-right"></i>
          <span>Logout</span>
        </button>
      </form>
    </li>

  </ul>
</aside>
