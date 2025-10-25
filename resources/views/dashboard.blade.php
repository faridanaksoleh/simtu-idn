@extends('layouts.app')

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center">
  <div>
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div>
  <form action="{{ route('logout') }}" method="POST" class="m-0">
    @csrf
    <button type="submit" class="btn btn-danger">
      <i class="bi bi-box-arrow-right me-1"></i> Logout
    </button>
  </form>
</div>

<section class="section dashboard mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0" style="border-radius: 1rem;">
        <div class="card-body text-center p-5">
          <h3 class="card-title mb-3">👋 Hello, <span class="text-primary">{{ Auth::user()->name }}</span></h3>
          <p class="text-muted fs-5 mb-4">Selamat datang di <strong>Sistem Tabungan Umrah Mahasiswa IDN</strong> 🎉</p>

          <div class="d-flex justify-content-center">
            @if (Auth::user()->role === 'admin')
              <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 me-2">
                <i class="bi bi-speedometer2 me-1"></i> Panel Admin
              </a>
            @elseif (Auth::user()->role === 'koordinator')
              <a href="{{ route('dashboard') }}" class="btn btn-success px-4 me-2">
                <i class="bi bi-people me-1"></i> Data Mahasiswa
              </a>
            @else
              <a href="{{ route('dashboard') }}" class="btn btn-info px-4">
                <i class="bi bi-wallet2 me-1"></i> Lihat Tabungan Saya
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
