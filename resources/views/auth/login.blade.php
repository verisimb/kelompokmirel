@extends('layouts.auth')

@section('title', 'Login')
@section('content')
<h5 class="fw-bold text-center mb-1" style="color: #1a1a2e;">Login</h5>
<p class="text-muted text-center mb-4" style="font-size: 13px;">Masuk ke dashboard</p>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label fw-medium" style="font-size: 13px;">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="admin@spk.com" style="border-radius: 10px;">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-medium" style="font-size: 13px;">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••" style="border-radius: 10px;">
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember" style="font-size: 13px; color: #475569;">Ingat saya</label>
        </div>
        <a href="{{ route('password.request') }}" style="font-size: 13px; color: #4F46E5; text-decoration: none;">Lupa Password?</a>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2" style="background: #4F46E5; border: none; border-radius: 10px; font-weight: 600;">
        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
    </button>
</form>

<div class="text-center mt-3">
    <p style="font-size: 13px; color: #94a3b8;">
        Belum punya akun? <a href="{{ route('register') }}" style="color: #4F46E5; text-decoration: none; font-weight: 600;">Daftar</a>
    </p>
</div>

{{-- HAPUS BAGIAN INI --}}
{{-- 
<div class="mt-3 p-2 text-center" style="background: #f8fafc; border-radius: 8px; border: 1px dashed #e2e8f0;">
    <p style="font-size: 11px; color: #94a3b8; margin: 0;">
        <strong>Akun Default:</strong> admin@spk.com / admin123 (Admin)
    </p>
</div>
--}}

@endsection