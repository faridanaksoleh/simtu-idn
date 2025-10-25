@extends('layouts.app')

@section('content')
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Hello, {{ Auth::user()->name }} 👋</h5>
          <p>Selamat datang di Sistem Tabungan Umrah 🎉</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
