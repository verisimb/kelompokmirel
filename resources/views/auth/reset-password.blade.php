@extends('layouts.auth')

@section('title', 'Reset Password')
@section('content')
<h5 class="fw-bold text-center mb-1" style="color: #1a1a2e;">Reset Password</h5>
<p class="text-muted text-center mb-4" style="font-size: 13px;">Buat password baru</p>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i> Terjadi kesalahan.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="mb-3">
        <label for="email" class="form-label fw-medium" style="font-size: 13px;">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="admin@spk.com" style="border-radius: 10px;">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-medium" style="font-size: 13px;">Password Baru</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 karakter" style="border-radius: 10px;">
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="form-label fw-medium" style="font-size: 13px;">Konfirmasi Password Baru</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" style="border-radius: 10px;">
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2" style="background: #4F46E5; border: none; border-radius: 10px; font-weight: 600;">
        <i class="bi bi-check-circle me-1"></i> Reset Password
    </button>
</form>

<div class="text-center mt-3">
    <p style="font-size: 13px; color: #94a3b8;">
        <a href="{{ route('login') }}" style="color: #4F46E5; text-decoration: none; font-weight: 600;">← Kembali ke Login</a>
    </p>
</div>
@endsection