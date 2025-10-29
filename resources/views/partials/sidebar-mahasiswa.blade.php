<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? '' : 'collapsed' }}" href="{{ route('mahasiswa.dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard Mahasiswa</span>
      </a>
    </li>

    <li class="nav-heading">Tabungan Saya</li>

    <!-- Riwayat Transaksi -->
    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('mahasiswa.transaksi') ? '' : 'collapsed' }}" href="{{ route('mahasiswa.transaksi') }}">
        <i class="bi bi-wallet2"></i>
        <span>Riwayat Transaksi</span>
      </a>
    </li>

    <!-- Target Umrah -->
    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('mahasiswa.tabungan') ? '' : 'collapsed' }}" href="{{ route('mahasiswa.tabungan') }}">
        <i class="bi bi-bullseye"></i>
        <span>Target Umrah</span>
      </a>
    </li>

    <!-- Konsultasi -->
    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('mahasiswa.konsultasi') ? '' : 'collapsed' }}" href="{{ route('mahasiswa.konsultasi') }}">
        <i class="bi bi-chat-dots"></i>
        <span>Konsultasi</span>
      </a>
    </li>

    <li class="nav-heading">Akun</li>

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
