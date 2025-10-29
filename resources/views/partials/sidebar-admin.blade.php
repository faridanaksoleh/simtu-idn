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
        <i class="bi bi-tags"></i>
        <span>Kategori Tabungan</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.transaksi') ? '' : 'collapsed' }}" href="{{ route('admin.transaksi') }}">
        <i class="bi bi-cash-stack"></i>
        <span>Data Transaksi</span>
      </a>
    </li>

    <li class="nav-item">
      <a wire:navigate class="nav-link {{ request()->routeIs('admin.target') ? '' : 'collapsed' }}" href="{{ route('admin.target') }}">
        <i class="bi bi-bullseye"></i>
        <span>Target Tabungan</span>
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
