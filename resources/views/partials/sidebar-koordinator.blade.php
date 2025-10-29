<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('koordinator.dashboard') ? '' : 'collapsed' }}" href="{{ route('koordinator.dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-heading">Data & Laporan</li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('koordinator.data-mahasiswa') ? '' : 'collapsed' }}" href="{{ route('koordinator.data-mahasiswa') }}">
        <i class="bi bi-people"></i>
        <span>Data Mahasiswa</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('koordinator.laporan-tabungan') ? '' : 'collapsed' }}" href="{{ route('koordinator.laporan-tabungan') }}">
        <i class="bi bi-cash-stack"></i>
        <span>Laporan Tabungan</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('koordinator.catatan-konsultasi') ? '' : 'collapsed' }}" href="{{ route('koordinator.catatan-konsultasi') }}">
        <i class="bi bi-chat-left-text"></i>
        <span>Catatan Konsultasi</span>
      </a>
    </li>

    <li class="nav-heading">Akun</li>
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
