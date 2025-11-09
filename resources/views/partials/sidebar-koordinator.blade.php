<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('koordinator.dashboard') ? '' : 'collapsed' }}" href="{{ route('koordinator.dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-heading">Manajemen Data</li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('koordinator.progress-mahasiswa') ? '' : 'collapsed' }}" href="{{ route('koordinator.progress-mahasiswa') }}">
        <i class="bi bi-person-lines-fill"></i>
        <span>Progress Mahasiswa</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('koordinator.koordinator-transaksi') ? '' : 'collapsed' }}" href="{{ route('koordinator.koordinator-transaksi') }}">
        <i class="bi bi-cash-coin"></i>
        <span>Transaksi</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('koordinator.konsultasi-mahasiswa') ? '' : 'collapsed' }}" href="{{ route('koordinator.konsultasi-mahasiswa') }}">
        <i class="bi bi-chat-dots"></i>
        <span>Konsultasi Mahasiswa</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('koordinator.laporan-keuangan') ? '' : 'collapsed' }}" href="{{ route('koordinator.laporan-keuangan') }}">
        <i class="bi bi-graph-up"></i>
        <span>Laporan Keuangan</span>
      </a>
    </li>

    
    <li class="nav-heading">Akun</li>
    
    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('koordinator.profil') ? '' : 'collapsed' }}" href="{{ route('koordinator.profil') }}">
        <i class="bi bi-person"></i>
        <span>Profil</span>
      </a>
    </li>

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