<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.dashboard') ? '' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-heading">Manajemen Data</li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.users') ? '' : 'collapsed' }}" href="{{ route('admin.users') }}">
        <i class="bi bi-people"></i>
        <span>Kelola User</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.kategori') ? '' : 'collapsed' }}" href="{{ route('admin.kategori') }}">
        <i class="bi bi-list-task"></i>
        <span>Kelola Kategori</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.semua-transaksi') ? '' : 'collapsed' }}" href="{{ route('admin.semua-transaksi') }}">
        <i class="bi bi-cash"></i>
        <span>Semua Transaksi</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.persetujuan-transaksi') ? '' : 'collapsed' }}" href="{{ route('admin.persetujuan-transaksi') }}">
        <i class="bi bi-check-circle"></i>
        <span>Persetujuan Transaksi</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.laporan-keuangan') ? '' : 'collapsed' }}" href="{{ route('admin.laporan-keuangan') }}">
        <i class="bi bi-file-text"></i>
        <span>Laporan Keuangan</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.notifikasi') ? '' : 'collapsed' }}" href="{{ route('admin.notifikasi') }}">
        <i class="bi bi-bell"></i>
        <span>Notifikasi</span>
      </a>
    </li>

    
    <li class="nav-heading">Akun</li>
    
    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.profil') ? '' : 'collapsed' }}" href="{{ route('admin.profil') }}">
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
