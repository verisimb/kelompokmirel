@extends('layouts.auth')

@section('title', 'Register')
@section('content')
<h5 class="fw-bold text-center mb-1" style="color: #1a1a2e;">Daftar</h5>
<p class="text-muted text-center mb-4" style="font-size: 13px;">Buat akun baru</p>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i> Terjadi kesalahan.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form action="{{ route('register') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label fw-medium" style="font-size: 13px;">Nama Lengkap</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" style="border-radius: 10px;">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-medium" style="font-size: 13px;">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" style="border-radius: 10px;">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-medium" style="font-size: 13px;">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 karakter" style="border-radius: 10px;">
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label fw-medium" style="font-size: 13px;">Konfirmasi Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" style="border-radius: 10px;">
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2" style="background: #4F46E5; border: none; border-radius: 10px; font-weight: 600;">
        <i class="bi bi-person-plus me-1"></i> Daftar
    </button>
</form>

<div class="text-center mt-3">
    <p style="font-size: 13px; color: #94a3b8;">
        Sudah punya akun? <a href="{{ route('login') }}" style="color: #4F46E5; text-decoration: none; font-weight: 600;">Masuk</a>
    </p>
</div>
@endsection