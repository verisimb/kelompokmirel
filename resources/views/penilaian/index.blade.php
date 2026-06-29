@extends('layouts.app')

@section('title', 'Penilaian')
@section('page-title', 'Input Penilaian')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
    <div class="card-body p-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap">
            <div>
                <h5 class="fw-bold mb-1" style="color: #1a1a2e; font-size: 1.25rem;">
                    <i class="bi bi-pencil-square me-2" style="color: #4F46E5;"></i>Input Nilai Setiap Alternatif
                </h5>
                <p class="text-muted" style="font-size: 0.9rem;">Isi <strong>semua nilai</strong> untuk setiap alternatif terhadap setiap kriteria sebelum menyimpan.</p>
            </div>
            @php
                $totalCells = count($alternatif) * count($kriteria);
                $filledCells = 0;
                foreach ($alternatif as $alt) {
                    foreach ($kriteria as $krit) {
                        if (isset($matriks[$alt->id][$krit->id]) && $matriks[$alt->id][$krit->id] !== null && $matriks[$alt->id][$krit->id] !== '') {
                            $filledCells++;
                        }
                    }
                }
                $percent = $totalCells > 0 ? round(($filledCells / $totalCells) * 100) : 0;
            @endphp
            <div class="mt-2 mt-sm-0">
            </div>
        </div>

        <!-- Flash Messages -->
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
            <strong>Semua nilai harus diisi sebelum menyimpan.</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('penilaian.store') }}" method="POST" id="formPenilaian">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" style="border-radius: 16px; overflow: hidden; min-width: 700px; font-size: 0.9rem;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th style="border-radius: 12px 0 0 0; padding: 12px 16px; min-width: 130px; vertical-align: middle; text-align: center; background: #f8fafc;">
                                Alternatif
                            </th>
                            @foreach($kriteria as $krit)
                            <th class="text-center" style="padding: 12px 8px; min-width: 110px; vertical-align: middle; background: #f8fafc;">
                                <div style="font-weight: 700; font-size: 0.95rem; color: #1a1a2e;">{{ $krit->kode_kriteria }}</div>
                                <div style="font-size: 0.8rem; color: #475569; font-weight: 500;">{{ $krit->nama_kriteria }}</div>
                                @if($krit->satuan)
                                <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 2px;">{{ $krit->satuan }}</div>
                                @endif
                                <span class="badge {{ $krit->tipe == 'benefit' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 text-{{ $krit->tipe == 'benefit' ? 'success' : 'danger' }} px-2 py-1 mt-1" style="font-weight: 500; font-size: 0.65rem; border-radius: 50px;">
                                    {{ ucfirst($krit->tipe) }}
                                </span>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatif as $alt)
                        <tr>
                            <td style="padding: 8px 16px; font-weight: 600; vertical-align: middle; text-align: center; background: #fafcff;">
                                {{ $alt->kode_alternatif }}
                                <br>
                                <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 400;">{{ $alt->nama_ewallet }}</span>
                            </td>
                            @foreach($kriteria as $krit)
                            @php
                                $rawValue = isset($matriks[$alt->id][$krit->id]) ? $matriks[$alt->id][$krit->id] : '';
                                $displayValue = '';
                                if (is_numeric($rawValue)) {
                                    if (floor($rawValue) == $rawValue) {
                                        $displayValue = (int)$rawValue;
                                    } else {
                                        $displayValue = rtrim(rtrim(sprintf('%.2f', $rawValue), '0'), '.');
                                    }
                                } else {
                                    $displayValue = $rawValue;
                                }
                                $fieldName = "nilai[{$alt->id}][{$krit->id}]";
                                $hasError = $errors->has($fieldName);
                            @endphp
                            <td class="text-center" style="padding: 4px 6px; vertical-align: middle;">
                                <input type="text" 
                                       class="form-control form-control-sm text-center @error($fieldName) is-invalid @enderror" 
                                       name="{{ $fieldName }}" 
                                       value="{{ old($fieldName, $displayValue) }}" 
                                       placeholder="–"
                                       style="width: 85px; margin: 0 auto; border-radius: 8px; border: 1px solid {{ $hasError ? '#dc3545' : '#e2e8f0' }}; font-size: 0.9rem; padding: 4px 6px; background: #fff; transition: border 0.2s;"
                                       onfocus="this.style.borderColor='#4F46E5'"
                                       onblur="this.style.borderColor='{{ $hasError ? '#dc3545' : '#e2e8f0' }}'"
                                       required>
                                @error($fieldName)
                                <div class="invalid-feedback d-block" style="font-size: 0.65rem;">{{ $message }}</div>
                                @enderror
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary" style="background: #4F46E5; border: none; border-radius: 12px; padding: 10px 32px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="bi bi-save"></i> Simpan Nilai
                </button>
                <!-- Tombol Kembali dihapus -->
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Validasi client-side: semua field harus terisi dan angka
        $('#formPenilaian').on('submit', function(e) {
            let hasError = false;
            let emptyFields = [];

            $('input[type="text"]').each(function() {
                let val = $(this).val().trim();
                if (val === '') {
                    hasError = true;
                    $(this).addClass('is-invalid');
                    emptyFields.push($(this).attr('name'));
                } else if (isNaN(val)) {
                    hasError = true;
                    $(this).addClass('is-invalid');
                    emptyFields.push($(this).attr('name') + ' (bukan angka)');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (hasError) {
                e.preventDefault();
                let message = 'Pastikan semua nilai terisi dan berupa angka.';
                if (emptyFields.length > 0) {
                    message += '\nField yang bermasalah: ' + emptyFields.join(', ');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Input Belum Lengkap',
                    text: message,
                    confirmButtonColor: '#4F46E5'
                });
            }
        });

        // Hapus error saat user mengetik
        $('input[type="text"]').on('input', function() {
            $(this).removeClass('is-invalid');
        });
    });
</script>
@endpush