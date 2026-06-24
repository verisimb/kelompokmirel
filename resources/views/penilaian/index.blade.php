@extends('layouts.app')

@section('title', 'Penilaian')
@section('page-title', 'Input Penilaian')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <h5 class="card-title fw-semibold" style="color: #1e293b;">Input Nilai Setiap Alternatif</h5>
        <p class="text-muted" style="font-size: 14px;">Masukkan nilai untuk setiap alternatif terhadap seluruh kriteria.</p>
        <hr>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> 
            <strong>Terjadi kesalahan validasi:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('penilaian.store') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="tablePenilaian">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th style="border-radius: 12px 0 0 0; min-width: 150px;">Alternatif / Kriteria</th>
                            @foreach($kriteria as $krit)
                            <th class="text-center">
                                {{ $krit->kode_kriteria }}
                                <br>
                                <small class="text-muted">{{ $krit->nama_kriteria }}</small>
                                @if($krit->satuan)
                                <br>
                                <small class="text-muted" style="font-size: 10px;">{{ $krit->satuan }}</small>
                                @endif
                                <br>
                                <span class="badge {{ $krit->tipe == 'benefit' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 text-{{ $krit->tipe == 'benefit' ? 'success' : 'danger' }} px-2 py-1" style="font-weight: 400; font-size: 10px;">
                                    {{ ucfirst($krit->tipe) }}
                                </span>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatif as $alt)
                        <tr>
                            <td>
                                <strong>{{ $alt->kode_alternatif }}</strong>
                                <br>
                                <small class="text-muted">{{ $alt->nama_ewallet }}</small>
                            </td>
                            @foreach($kriteria as $krit)
                            <td class="text-center" style="min-width: 120px;">
                                <input type="number" 
                                       class="form-control form-control-sm @error('nilai.' . $alt->id . '.' . $krit->id) is-invalid @enderror" 
                                       name="nilai[{{ $alt->id }}][{{ $krit->id }}]" 
                                       value="{{ old('nilai.' . $alt->id . '.' . $krit->id, isset($matriks[$alt->id][$krit->id]) && $matriks[$alt->id][$krit->id] !== null ? $matriks[$alt->id][$krit->id] : '') }}" 
                                       placeholder="{{ $krit->satuan ?: 'Nilai' }}"
                                       step="any"
                                       style="border-radius: 8px; text-align: center; width: 100px; margin: 0 auto;">
                                @error('nilai.' . $alt->id . '.' . $krit->id)
                                <div class="invalid-feedback d-block text-danger" style="font-size: 11px;">
                                    {{ $message }}
                                </div>
                                @enderror
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary" style="background: #4F46E5; border: none; border-radius: 10px; padding: 10px 30px;">
                    <i class="bi bi-save me-1"></i> Simpan Semua Penilaian
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 10px 30px;">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tablePenilaian').DataTable({
            paging: false,
            searching: false,
            info: false,
            ordering: false,
            responsive: true,
            columnDefs: [
                { width: '150px', targets: 0 }
            ]
        });
    });
</script>
@endpush