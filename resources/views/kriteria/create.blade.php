@extends('layouts.app')

@section('title', 'Tambah Kriteria')
@section('page-title', 'Tambah Kriteria')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <h5 class="card-title fw-semibold" style="color: #1e293b;">➕ Tambah Kriteria Baru</h5>
        <hr>

        <form action="{{ route('kriteria.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Kode Kriteria (Datalist) -->
                <div class="col-md-6 mb-3">
                    <label for="kode_kriteria" class="form-label fw-medium">Kode Kriteria <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('kode_kriteria') is-invalid @enderror" 
                           id="kode_kriteria" 
                           name="kode_kriteria" 
                           list="kodeList"
                           value="{{ old('kode_kriteria') }}" 
                           placeholder="C1, C2, C3, ..." 
                           style="border-radius: 10px;" 
                           autocomplete="off">
                    <datalist id="kodeList">
                        <option value="C1">C1 - Rating Aplikasi</option>
                        <option value="C2">C2 - Jumlah Pengguna</option>
                        <option value="C3">C3 - Biaya Tarik Tunai</option>
                        <option value="C4">C4 - Cashback / Promo</option>
                        <option value="C5">C5 - Ukuran Aplikasi</option>
                        <option value="C6">C6 - Keamanan</option>
                        <option value="C7">C7 - Kemudahan</option>
                        <option value="C8">C8 - Dukungan Pelanggan</option>
                        <option value="C9">C9 - Fitur</option>
                        <option value="C10">C10 - Kecepatan</option>
                    </datalist>
                    <small class="text-muted">Ketik kode atau pilih dari daftar. Bisa juga buat sendiri!</small>
                    @error('kode_kriteria')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Kriteria (Datalist) -->
                <div class="col-md-6 mb-3">
                    <label for="nama_kriteria" class="form-label fw-medium">Nama Kriteria <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('nama_kriteria') is-invalid @enderror" 
                           id="nama_kriteria" 
                           name="nama_kriteria" 
                           list="namaList"
                           value="{{ old('nama_kriteria') }}" 
                           placeholder="Contoh: Keamanan" 
                           style="border-radius: 10px;" 
                           autocomplete="off">
                    <datalist id="namaList">
                        <option value="Rating Aplikasi">
                        <option value="Jumlah Pengguna">
                        <option value="Biaya Tarik Tunai">
                        <option value="Cashback / Promo">
                        <option value="Ukuran Aplikasi">
                        <option value="Keamanan">
                        <option value="Kemudahan Penggunaan">
                        <option value="Dukungan Pelanggan">
                        <option value="Fitur">
                        <option value="Kecepatan Transaksi">
                        <option value="Promo">
                        <option value="Biaya Admin">
                        <option value="Kualitas">
                    </datalist>
                    <small class="text-muted">Ketik nama atau pilih dari daftar. Bisa juga buat sendiri!</small>
                    @error('nama_kriteria')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bobot (DROPDOWN 1-10) -->
                <div class="col-md-6 mb-3">
                    <label for="bobot" class="form-label fw-medium">Bobot <span class="text-danger">*</span></label>
                    <select class="form-select @error('bobot') is-invalid @enderror" 
                            id="bobot" name="bobot" style="border-radius: 10px;">
                        <option value="">-- Pilih Bobot --</option>
                        <option value="1" {{ old('bobot') == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ old('bobot') == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ old('bobot') == 3 ? 'selected' : '' }}>3</option>
                        <option value="4" {{ old('bobot') == 4 ? 'selected' : '' }}>4</option>
                        <option value="5" {{ old('bobot') == 5 ? 'selected' : '' }}>5</option>
                        <option value="6" {{ old('bobot') == 6 ? 'selected' : '' }}>6</option>
                        <option value="7" {{ old('bobot') == 7 ? 'selected' : '' }}>7</option>
                        <option value="8" {{ old('bobot') == 8 ? 'selected' : '' }}>8</option>
                        <option value="9" {{ old('bobot') == 9 ? 'selected' : '' }}>9</option>
                        <option value="10" {{ old('bobot') == 10 ? 'selected' : '' }}>10</option>
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
                        <option value="benefit" {{ old('tipe') == 'benefit' ? 'selected' : '' }}>Benefit (Semakin tinggi semakin baik)</option>
                        <option value="cost" {{ old('tipe') == 'cost' ? 'selected' : '' }}>Cost (Semakin rendah semakin baik)</option>
                    </select>
                    @error('tipe')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Satuan (DROPDOWN) -->
                <div class="col-md-12 mb-3">
                    <label for="satuan" class="form-label fw-medium">Satuan <span class="text-danger">*</span></label>
                    <select class="form-select @error('satuan') is-invalid @enderror" 
                            id="satuan" name="satuan" style="border-radius: 10px;">
                        <option value="">-- Pilih Satuan --</option>
                        <option value="Bintang (1-5)" {{ old('satuan') == 'Bintang (1-5)' ? 'selected' : '' }}>⭐ Bintang (1-5)</option>
                        <option value="Juta Orang" {{ old('satuan') == 'Juta Orang' ? 'selected' : '' }}>👥 Juta Orang</option>
                        <option value="Rupiah (Rp)" {{ old('satuan') == 'Rupiah (Rp)' ? 'selected' : '' }}>💰 Rupiah (Rp)</option>
                        <option value="Persen (%)" {{ old('satuan') == 'Persen (%)' ? 'selected' : '' }}>📊 Persen (%)</option>
                        <option value="Megabyte (MB)" {{ old('satuan') == 'Megabyte (MB)' ? 'selected' : '' }}>💾 Megabyte (MB)</option>
                    </select>
                    @error('satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary" style="background: #4F46E5; border: none; border-radius: 10px; padding: 10px 30px;">
                        <i class="bi bi-save me-1"></i> Simpan
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