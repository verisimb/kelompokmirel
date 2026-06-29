@extends('layouts.app')

@section('title', 'Perhitungan SMART')
@section('page-title', 'Perhitungan SMART - Step by Step')

@section('content')
<div class="fade-in">

    <!-- ===== HEADER ===== -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; background: linear-gradient(135deg, #EEF2FF, #E0E7FF);">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3">
                <div style="background: #4F46E5; width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-calculator-fill text-white" style="font-size: 22px;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="color: #1a1a2e;">Perhitungan SMART</h5>
                    <p class="text-muted mb-0" style="font-size: 14px;">
                        Proses perhitungan <strong>Step by Step</strong> menggunakan metode SMART 
                        (Simple Multi-Attribute Rating Technique)
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if(isset($message))
    <div class="alert alert-warning" style="border-radius: 16px; border-left: 4px solid #F59E0B;">
        <i class="bi bi-info-circle me-2"></i> {{ $message }}
    </div>
    @endif

    <!-- ===== PROGRESS STEP ===== -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; background: #f8fafc;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center position-relative" style="max-width: 700px; margin: 0 auto;">
                <div style="position: absolute; top: 50%; left: 8%; right: 8%; height: 3px; background: #e2e8f0; transform: translateY(-50%); z-index: 0;"></div>
                
                <div class="text-center position-relative" style="z-index: 1; cursor: pointer;" onclick="scrollToStep('step1')">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #4F46E5; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; margin: 0 auto; box-shadow: 0 4px 12px rgba(79,70,229,0.3);">1</div>
                    <div style="font-size: 11px; font-weight: 600; color: #4F46E5; margin-top: 6px;">Normalisasi</div>
                    <div style="font-size: 9px; color: #94a3b8;">Bobot Kriteria</div>
                </div>

                <div class="text-center position-relative" style="z-index: 1; cursor: pointer;" onclick="scrollToStep('step2')">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #10B981; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; margin: 0 auto; box-shadow: 0 4px 12px rgba(16,185,129,0.3);">2</div>
                    <div style="font-size: 11px; font-weight: 600; color: #10B981; margin-top: 6px;">Utility</div>
                    <div style="font-size: 9px; color: #94a3b8;">Nilai Alternatif</div>
                </div>

                <div class="text-center position-relative" style="z-index: 1; cursor: pointer;" onclick="scrollToStep('step3')">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #F59E0B; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; margin: 0 auto; box-shadow: 0 4px 12px rgba(245,158,11,0.3);">3</div>
                    <div style="font-size: 11px; font-weight: 600; color: #F59E0B; margin-top: 6px;">Hasil Akhir</div>
                    <div style="font-size: 9px; color: #94a3b8;">Nilai SMART</div>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($bobotNormalisasi) && count($bobotNormalisasi) > 0)

    <!-- ============================================================ -->
    <!-- STEP 1: NORMALISASI BOBOT -->
    <!-- ============================================================ -->
    <div id="step1" class="card border-0 shadow-sm mb-4" style="border-radius: 20px; scroll-margin-top: 80px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="background: #4F46E5; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px;">1</div>
                <div>
                    <h6 class="fw-bold mb-0" style="color: #1e293b;">Normalisasi Bobot Kriteria</h6>
                    <p class="text-muted mb-0" style="font-size: 13px;">Mengubah bobot awal menjadi bobot relatif (total = 1.0000)</p>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary ms-auto px-3 py-2 rounded-pill" style="font-size: 11px; font-weight: 500;">Step 1 of 3</span>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-bordered" style="border-radius: 12px; overflow: hidden;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <!-- KOLOM KRITERIA: KIRI (text-left) -->
                            <th class="text-center" style="padding: 10px 16px; text-align: left;">Kriteria</th>
                            <th class="text-center" style="padding: 10px 16px;">Bobot Awal</th>
                            <th class="text-center" style="padding: 10px 16px;">Bobot Normalisasi</th>
                            <th class="text-center" style="padding: 10px 16px;">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriteria as $krit)
                        <tr>
                            <!-- ISI KOLOM KRITERIA: KIRI (text-left) -->
                            <td style="padding: 8px 16px; text-align: left;">
                                <span style="font-weight: 700; color: #000000;">{{ $krit->kode_kriteria }}</span>
                                <span style="font-weight: 400; color: #475569;"> - {{ $krit->nama_kriteria }}</span>
                            </td>
                            <td class="text-center">{{ number_format($krit->bobot, 2) }}</td>
                            <td class="text-center">{{ number_format($bobotNormalisasi[$krit->id], 4) }}</td>
                            <td class="text-center">{{ number_format($bobotNormalisasi[$krit->id] * 100, 1) }}%</td>
                        </tr>
                        @endforeach
                        <tr style="background: #f8fafc; font-weight: 700;">
                            <td style="padding: 8px 16px; text-align: left;">TOTAL</td>
                            <td class="text-center">{{ $kriteria->sum('bobot') }}</td>
                            <td class="text-center">1.0000</td>
                            <td class="text-center">100%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- STEP 2: UTILITY VALUE -->
    <!-- ============================================================ -->
    <div id="step2" class="card border-0 shadow-sm mb-4" style="border-radius: 20px; scroll-margin-top: 80px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="background: #10B981; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px;">2</div>
                <div>
                    <h6 class="fw-bold mb-0" style="color: #1e293b;">Perhitungan Nilai Utilitas</h6>
                    <p class="text-muted mb-0" style="font-size: 13px;">Menghitung nilai utilitas setiap alternatif per kriteria (urutan berdasarkan kode alternatif)</p>
                </div>
                <span class="badge bg-success bg-opacity-10 text-success ms-auto px-3 py-2 rounded-pill" style="font-size: 11px; font-weight: 500;">Step 2 of 3</span>
            </div>

            <!-- Max & Min Info - Clean Version -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3" style="background: #f8fafc; border-radius: 10px; border: 1px solid #eef2f6;">
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 500; letter-spacing: 0.5px; text-transform: uppercase;">Nilai Maksimum</div>
                        <div class="d-flex gap-3 flex-wrap mt-1">
                            @foreach($kriteria as $krit)
                            <span style="font-size: 13px; color: #1e293b; font-weight: 500;">{{ $krit->kode_kriteria }}: <span style="color: #10B981;">{{ number_format($maxValues[$krit->id] ?? 0, 2) }}</span></span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3" style="background: #f8fafc; border-radius: 10px; border: 1px solid #eef2f6;">
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 500; letter-spacing: 0.5px; text-transform: uppercase;">Nilai Minimum</div>
                        <div class="d-flex gap-3 flex-wrap mt-1">
                            @foreach($kriteria as $krit)
                            <span style="font-size: 13px; color: #1e293b; font-weight: 500;">{{ $krit->kode_kriteria }}: <span style="color: #EF4444;">{{ number_format($minValues[$krit->id] ?? 0, 2) }}</span></span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Utility -->
            <div class="table-responsive">
                <table class="table table-sm table-bordered" style="border-radius: 12px; overflow: hidden;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="text-center" style="padding: 8px 14px; min-width: 120px;">Alternatif</th>
                            @foreach($kriteria as $krit)
                            <th class="text-center" style="padding: 8px 10px; font-size: 12px; min-width: 80px;">
                                {{ $krit->kode_kriteria }}
                                <br>
                                <small style="font-size: 9px; color: #94a3b8; font-weight: 400;">{{ $krit->nama_kriteria }}</small>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sortedHasil = $hasil;
                            usort($sortedHasil, function($a, $b) {
                                return strcmp($a['alternatif']->kode_alternatif, $b['alternatif']->kode_alternatif);
                            });
                        @endphp
                        @foreach($sortedHasil as $item)
                        <tr>
                            <td style="padding: 6px 14px; font-weight: 600; font-size: 13px; text-align: center;">
                                <div style="font-weight: 700; color: #000000;">{{ $item['alternatif']->kode_alternatif }}</div>
                                <small class="text-muted" style="font-size: 10px; font-weight: 400;">{{ $item['alternatif']->nama_ewallet }}</small>
                            </td>
                            @foreach($kriteria as $krit)
                            @php $val = $item['detail'][$krit->id]['utility'] ?? 0; @endphp
                            <td class="text-center" style="padding: 6px 8px; font-weight: 600; font-size: 14px; color: 
                                @if($val >= 0.7) #10B981; 
                                @elseif($val >= 0.4) #F59E0B; 
                                @else #94a3b8; @endif">
                                {{ number_format($val, 4) }}
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Legend Clean -->
            <div class="d-flex gap-3 mt-3 justify-content-center" style="font-size: 12px; color: #475569;">
                <span>🔵 <span style="color: #10B981; font-weight: 600;">≥ 0.70</span> (Tinggi)</span>
                <span>🟡 <span style="color: #F59E0B; font-weight: 600;">0.40 - 0.69</span> (Sedang)</span>
                <span>⚪ <span style="color: #94a3b8; font-weight: 600;">&lt; 0.40</span> (Rendah)</span>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- STEP 3: HASIL AKHIR -->
    <!-- ============================================================ -->
    <div id="step3" class="card border-0 shadow-sm mb-4" style="border-radius: 20px; scroll-margin-top: 80px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="background: #F59E0B; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px;">3</div>
                <div>
                    <h6 class="fw-bold mb-0" style="color: #1e293b;">Hasil Akhir</h6>
                    <p class="text-muted mb-0" style="font-size: 13px;">Nilai akhir SMART setiap alternatif (urutan berdasarkan kode alternatif)</p>
                </div>
                <span class="badge bg-warning bg-opacity-10 text-warning ms-auto px-3 py-2 rounded-pill" style="font-size: 11px; font-weight: 500;">Step 3 of 3</span>
            </div>

            <!-- Ringkasan Card -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="p-3 text-center" style="background: #f8fafc; border-radius: 12px; border: 1px solid #eef2f6;">
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 500; letter-spacing: 0.3px; text-transform: uppercase;">Nilai Tertinggi</div>
                        <div style="font-size: 22px; font-weight: 700; color: #1e293b;">
                            @if(!empty($hasil) && count($hasil) > 0)
                                {{ number_format($hasil[0]['nilai_akhir'] * 100, 1) }}%
                            @else
                                -
                            @endif
                        </div>
                        <div style="font-size: 13px; color: #4F46E5;">
                            @if(!empty($hasil) && count($hasil) > 0)
                                {{ $hasil[0]['alternatif']->nama_ewallet }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 text-center" style="background: #f8fafc; border-radius: 12px; border: 1px solid #eef2f6;">
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 500; letter-spacing: 0.3px; text-transform: uppercase;">Total Alternatif</div>
                        <div style="font-size: 22px; font-weight: 700; color: #1e293b;">{{ count($hasil) }}</div>
                        <div style="font-size: 13px; color: #475569;">E-Wallet dievaluasi</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 text-center" style="background: #f8fafc; border-radius: 12px; border: 1px solid #eef2f6;">
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 500; letter-spacing: 0.3px; text-transform: uppercase;">Rata-rata Nilai</div>
                        <div style="font-size: 22px; font-weight: 700; color: #1e293b;">
                            @if(!empty($hasil) && count($hasil) > 0)
                                @php $avg = collect($hasil)->avg('nilai_akhir'); @endphp
                                {{ number_format($avg * 100, 1) }}%
                            @else
                                -
                            @endif
                        </div>
                        <div style="font-size: 13px; color: #475569;">Dari semua alternatif</div>
                    </div>
                </div>
            </div>

            <!-- List Hasil Akhir - Clean -->
            <div style="background: #f8fafc; border-radius: 12px; padding: 12px; border: 1px solid #eef2f6;">
                @php
                    $sortedHasil = $hasil;
                    usort($sortedHasil, function($a, $b) {
                        return strcmp($a['alternatif']->kode_alternatif, $b['alternatif']->kode_alternatif);
                    });
                @endphp
                @foreach($sortedHasil as $item)
                <div style="display: flex; align-items: center; padding: 8px 12px; border-bottom: 1px solid #eef2f6; 
                    @if($loop->last) border-bottom: none; @endif">
                    <div style="width: 50px; font-weight: 700; font-size: 14px; color: #4F46E5;">
                        {{ $item['alternatif']->kode_alternatif }}
                    </div>
                    <div style="flex: 1; font-weight: 500; font-size: 14px; color: #1e293b;">
                        {{ $item['alternatif']->nama_ewallet }}
                    </div>
                    <div style="font-weight: 700; font-size: 15px; min-width: 100px; text-align: right; color: 
                        @if($item['nilai_akhir'] >= 0.7) #10B981; 
                        @elseif($item['nilai_akhir'] >= 0.4) #F59E0B; 
                        @else #94a3b8; @endif">
                        {{ number_format($item['nilai_akhir'] * 100, 1) }}%
                    </div>
                    <div style="width: 100px; margin-left: 12px;">
                        <div class="progress" style="height: 5px; border-radius: 5px; background: #e2e8f0;">
                            <div class="progress-bar" style="width: {{ $item['nilai_akhir'] * 100 }}%; 
                                background: 
                                @if($item['nilai_akhir'] >= 0.7) #10B981;
                                @elseif($item['nilai_akhir'] >= 0.4) #F59E0B;
                                @else #94a3b8; @endif
                                border-radius: 5px;">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-3 text-center">
                <span style="font-size: 12px; color: #94a3b8;">
                    <i class="bi bi-info-circle me-1"></i> 
                    Nilai diurutkan berdasarkan kode alternatif (A1, A2, A3, ...)
                </span>
                <br>
                <span style="font-size: 11px; color: #cbd5e1;">
                    <i class="bi bi-arrow-right me-1"></i>
                    Untuk melihat perankingan, klik tombol "Lihat Ranking"
                </span>
            </div>
        </div>
    </div>

    @else
    <div class="alert alert-info" style="border-radius: 16px; border-left: 4px solid #0EA5E9;">
        <i class="bi bi-info-circle me-2"></i> Belum ada data untuk ditampilkan. Pastikan Anda sudah mengisi kriteria, alternatif, dan penilaian.
    </div>
    @endif

    <!-- ===== TOMBOL NAVIGASI ===== -->
    <div class="d-flex gap-3 mt-3">
        @if(!empty($hasil) && count($hasil) > 0)
        <a href="{{ route('ranking.index') }}" class="btn btn-primary" style="background: #4F46E5; border: none; border-radius: 12px; padding: 10px 28px; font-weight: 600;">
            <i class="bi bi-trophy me-1"></i> Lihat Ranking
        </a>
        @endif
        <!-- TOMBOL KEMBALI DIHAPUS -->
    </div>

</div>

<script>
    function scrollToStep(id) {
        document.getElementById(id).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
</script>
@endsection