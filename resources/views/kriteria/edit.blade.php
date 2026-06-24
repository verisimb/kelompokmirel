@extends('layouts.app')

@section('title', 'Edit Kriteria')
@section('page-title', 'Edit Kriteria')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <h5 class="card-title fw-semibold" style="color: #1e293b;">✏️ Edit Kriteria: {{ $kriteria->kode_kriteria }}</h5>
        <hr>

        <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Kode Kriteria -->
                <div class="col-md-6 mb-3">
                    <label for="kode_kriteria" class="form-label fw-medium">Kode Kriteria <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('kode_kriteria') is-invalid @enderror" 
                           id="kode_kriteria" 
                           name="kode_kriteria" 
                           value="{{ old('kode_kriteria', $kriteria->kode_kriteria) }}" 
                           placeholder="Contoh: C1" 
                           style="border-radius: 10px;">
                    @error('kode_kriteria')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Kriteria -->
                <div class="col-md-6 mb-3">
                    <label for="nama_kriteria" class="form-label fw-medium">Nama Kriteria <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('nama_kriteria') is-invalid @enderror" 
                           id="nama_kriteria" 
                           name="nama_kriteria" 
                           value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" 
                           placeholder="Contoh: Keamanan" 
                           style="border-radius: 10px;">
                    @error('nama_kriteria')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bobot -->
                <div class="col-md-6 mb-3">
                    <label for="bobot" class="form-label fw-medium">Bobot <span class="text-danger">*</span></label>
                    <select class="form-select @error('bobot') is-invalid @enderror" 
                            id="bobot" name="bobot" style="border-radius: 10px;">
                        <option value="">-- Pilih Bobot --</option>
                        @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ old('bobot', $kriteria->bobot) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('bobot')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tipe -->
                <div class="col-md-6 mb-3">
                    <label for="tipe" class="form-label fw-medium">Tipe <span class="text-danger">*</span></label>
                    <select class="form-select @error('tipe') is-invalid @enderror" 
                            id="tipe" name="tipe" style="border-radius: 10px;">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="benefit" {{ old('tipe', $kriteria->tipe) == 'benefit' ? 'selected' : '' }}>Benefit (Semakin tinggi semakin baik)</option>
                        <option value="cost" {{ old('tipe', $kriteria->tipe) == 'cost' ? 'selected' : '' }}>Cost (Semakin rendah semakin baik)</option>
                    </select>
                    @error('tipe')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Satuan -->
                <div class="col-md-12 mb-3">
                    <label for="satuan" class="form-label fw-medium">Satuan <span class="text-danger">*</span></label>
                    <select class="form-select @error('satuan') is-invalid @enderror" 
                            id="satuan" name="satuan" style="border-radius: 10px;">
                        <option value="">-- Pilih Satuan --</option>
                        <option value="Bintang (1-5)" {{ old('satuan', $kriteria->satuan) == 'Bintang (1-5)' ? 'selected' : '' }}>⭐ Bintang (1-5)</option>
                        <option value="Juta Orang" {{ old('satuan', $kriteria->satuan) == 'Juta Orang' ? 'selected' : '' }}>👥 Juta Orang</option>
                        <option value="Rupiah (Rp)" {{ old('satuan', $kriteria->satuan) == 'Rupiah (Rp)' ? 'selected' : '' }}>💰 Rupiah (Rp)</option>
                        <option value="Persen (%)" {{ old('satuan', $kriteria->satuan) == 'Persen (%)' ? 'selected' : '' }}>📊 Persen (%)</option>
                        <option value="Megabyte (MB)" {{ old('satuan', $kriteria->satuan) == 'Megabyte (MB)' ? 'selected' : '' }}>💾 Megabyte (MB)</option>
                    </select>
                    @error('satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary" style="background: #4F46E5; border: none; border-radius: 10px; padding: 10px 30px;">
                        <i class="bi bi-save me-1"></i> Update
                    </button>
                    <a href="{{ route('kriteria.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 30px;">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection