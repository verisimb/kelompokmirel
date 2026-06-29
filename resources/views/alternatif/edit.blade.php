@extends('layouts.app')

@section('title', 'Edit Alternatif')
@section('page-title', 'Edit Alternatif (E-Wallet)')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <h5 class="card-title fw-semibold" style="color: #1e293b;">Edit E-Wallet: {{ $alternatif->kode_alternatif }}</h5>
        <hr>

        <form action="{{ route('alternatif.update', $alternatif->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode_alternatif" class="form-label fw-medium">Kode Alternatif <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('kode_alternatif') is-invalid @enderror" 
                           id="kode_alternatif" name="kode_alternatif" value="{{ old('kode_alternatif', $alternatif->kode_alternatif) }}" 
                           placeholder="Contoh: A1" style="border-radius: 10px;">
                    @error('kode_alternatif')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama_ewallet" class="form-label fw-medium">Nama E-Wallet <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_ewallet') is-invalid @enderror" 
                           id="nama_ewallet" name="nama_ewallet" value="{{ old('nama_ewallet', $alternatif->nama_ewallet) }}" 
                           placeholder="Contoh: DANA" style="border-radius: 10px;">
                    @error('nama_ewallet')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary" style="background: #4F46E5; border: none; border-radius: 10px; padding: 10px 30px;">
                        <i class="bi bi-save me-1"></i> Update
                    </button>
                    <a href="{{ route('alternatif.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 30px;">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection