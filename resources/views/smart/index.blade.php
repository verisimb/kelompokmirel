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
    <div id="step1" class="card border-0 shadow-sm mb-4" style="border-radius: 20px; border-left: 5px solid #4F46E5; scroll-margin-top: 80px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="background: #4F46E5; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">1</div>
                <div>
                    <h6 class="fw-bold mb-0" style="color: #1e293b;">Normalisasi Bobot Kriteria</h6>
                    <p class="text-muted mb-0" style="font-size: 13px;">Mengubah bobot awal menjadi bobot relatif (total = 1.0000)</p>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary ms-auto px-3 py-2 rounded-pill">Step 1 of 3</span>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-bordered" style="border-radius: 12px; overflow: hidden;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th style="padding: 10px 16px;">Kriteria</th>
                            <th class="text-center" style="padding: 10px 16px;">Bobot Awal</th>
                            <th class="text-center" style="padding: 10px 16px;">Bobot Normalisasi</th>
                            <th class="text-center" style="padding: 10px 16px;">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriteria as $krit)
                        <tr>
                            <td style="padding: 8px 16px; font-weight: 600;">{{ $krit->kode_kriteria }} - {{ $krit->nama_kriteria }}</td>
                            <td class="text-center">{{ number_format($krit->bobot, 2) }}</td>
                            <td class="text-center fw-bold" style="color: #4F46E5;">{{ number_format($bobotNormalisasi[$krit->id], 4) }}</td>
                            <td class="text-center">{{ number_format($bobotNormalisasi[$krit->id] * 100, 1) }}%</td>
                        </tr>
                        @endforeach
                        <tr style="background: #f8fafc; font-weight: 700;">
                            <td style="padding: 8px 16px;">TOTAL</td>
                            <td class="text-center">{{ $kriteria->sum('bobot') }}</td>
                            <td class="text-center" style="color: #4F46E5;">1.0000</td>
                            <td class="text-center">100%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- STEP 2: UTILITY VALUE (Urutan A1, A2, A3, ...) -->
    <!-- ============================================================ -->
    <div id="step2" class="card border-0 shadow-sm mb-4" style="border-radius: 20px; border-left: 5px solid #10B981; scroll-margin-top: 80px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="background: #10B981; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">2</div>
                <div>
                    <h6 class="fw-bold mb-0" style="color: #1e293b;">Perhitungan Nilai Utilitas</h6>
                    <p class="text-muted mb-0" style="font-size: 13px;">Menghitung nilai utilitas setiap alternatif per kriteria (urutan berdasarkan kode alternatif)</p>
                </div>
                <span class="badge bg-success bg-opacity-10 text-success ms-auto px-3 py-2 rounded-pill">Step 2 of 3</span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3" style="background: #f8fafc; border-radius: 12px; border: 1px solid #eef2f6;">
                        <div style="font-size: 12px; color: #94a3b8; font-weight: 500;">NILAI MAKSIMUM</div>
                        <div class="d-flex gap-3 flex-wrap mt-1">
                            @foreach($kriteria as $krit)
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">{{ $krit->kode_kriteria }}: {{ number_format($maxValues[$krit->id] ?? 0, 2) }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3" style="background: #f8fafc; border-radius: 12px; border: 1px solid #eef2f6;">
                        <div style="font-size: 12px; color: #94a3b8; font-weight: 500;">NILAI MINIMUM</div>
                        <div class="d-flex gap-3 flex-wrap mt-1">
                            @foreach($kriteria as $krit)
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">{{ $krit->kode_kriteria }}: {{ number_format($minValues[$krit->id] ?? 0, 2) }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-bordered" style="border-radius: 12px; overflow: hidden;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th style="padding: 8px 14px; min-width: 120px;">Alternatif</th>
                            @foreach($kriteria as $krit)
                            <th class="text-center" style="padding: 8px 10px; font-size: 12px; min-width: 80px;">
                                {{ $krit->kode_kriteria }}
                                <br>
                                <small style="font-size: 9px; color: #94a3b8;">{{ $krit->nama_kriteria }}</small>
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
                            <td style="padding: 6px 14px; font-weight: 600; font-size: 13px;">
                                {{ $item['alternatif']->kode_alternatif }}
                                <br>
                                <small class="text-muted" style="font-size: 10px;">{{ $item['alternatif']->nama_ewallet }}</small>
                            </td>
                            @foreach($kriteria as $krit)
                            @php 
                                $val = $item['detail'][$krit->id]['utility'] ?? 0;
                                $bgColor = $val >= 0.7 ? '#D1FAE5' : ($val >= 0.4 ? '#FEF3C7' : '#FEE2E2');
                                $textColor = $val >= 0.7 ? '#065F46' : ($val >= 0.4 ? '#92400E' : '#991B1B');
                            @endphp
                            <td class="text-center" style="padding: 6px 8px; font-weight: 700; font-size: 14px; background: {{ $bgColor }}; color: {{ $textColor }}; border-radius: 4px;">
                                {{ number_format($val, 4) }}
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex gap-3 mt-3 justify-content-center">
                <span style="display: flex; align-items: center; gap: 6px; font-size: 11px; color: #475569;">
                    <span style="display: inline-block; width: 16px; height: 16px; background: #D1FAE5; border-radius: 4px;"></span> ≥ 0.70 (Tinggi)
                </span>
                <span style="display: flex; align-items: center; gap: 6px; font-size: 11px; color: #475569;">
                    <span style="display: inline-block; width: 16px; height: 16px; background: #FEF3C7; border-radius: 4px;"></span> 0.40 - 0.69 (Sedang)
                </span>
                <span style="display: flex; align-items: center; gap: 6px; font-size: 11px; color: #475569;">
                    <span style="display: inline-block; width: 16px; height: 16px; background: #FEE2E2; border-radius: 4px;"></span> &lt; 0.40 (Rendah)
                </span>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- STEP 3: HASIL AKHIR (Urutan A1, A2, A3, ...) -->
    <!-- ============================================================ -->
    <div id="step3" class="card border-0 shadow-sm mb-4" style="border-radius: 20px; border-left: 5px solid #F59E0B; scroll-margin-top: 80px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="background: #F59E0B; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">3</div>
                <div>
                    <h6 class="fw-bold mb-0" style="color: #1e293b;">Hasil Akhir</h6>
                    <p class="text-muted mb-0" style="font-size: 13px;">Nilai akhir SMART setiap alternatif (urutan berdasarkan kode alternatif)</p>
                </div>
                <span class="badge bg-warning bg-opacity-10 text-warning ms-auto px-3 py-2 rounded-pill">Step 3 of 3</span>
            </div>

            <!-- RINGKASAN CARD -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="p-3 text-center" style="background: linear-gradient(135deg, #F59E0B, #D97706); border-radius: 14px; color: white;">
                        <div style="font-size: 11px; opacity: 0.8; font-weight: 500;">NILAI TERTINGGI</div>
                        <div style="font-size: 22px; font-weight: 800;">
                            @if(!empty($hasil) && count($hasil) > 0)
                                {{ number_format($hasil[0]['nilai_akhir'] * 100, 1) }}%
                            @else
                                -
                            @endif
                        </div>
                        <div style="font-size: 14px; font-weight: 500;">
                            @if(!empty($hasil) && count($hasil) > 0)
                                {{ $hasil[0]['alternatif']->nama_ewallet }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 text-center" style="background: linear-gradient(135deg, #4F46E5, #6366F1); border-radius: 14px; color: white;">
                        <div style="font-size: 11px; opacity: 0.8; font-weight: 500;">TOTAL ALTERNATIF</div>
                        <div style="font-size: 22px; font-weight: 800;">{{ count($hasil) }}</div>
                        <div style="font-size: 14px; font-weight: 500;">E-Wallet dievaluasi</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 text-center" style="background: linear-gradient(135deg, #10B981, #059669); border-radius: 14px; color: white;">
                        <div style="font-size: 11px; opacity: 0.8; font-weight: 500;">RATA-RATA NILAI</div>
                        <div style="font-size: 22px; font-weight: 800;">
                            @if(!empty($hasil) && count($hasil) > 0)
                                @php
                                    $avg = collect($hasil)->avg('nilai_akhir');
                                @endphp
                                {{ number_format($avg * 100, 1) }}%
                            @else
                                -
                            @endif
                        </div>
                        <div style="font-size: 14px; font-weight: 500;">Dari semua alternatif</div>
                    </div>
                </div>
            </div>

            <!-- LIST HASIL AKHIR (Urutan A1, A2, A3, ...) -->
            <div style="background: #f8fafc; border-radius: 14px; padding: 16px; border: 1px solid #eef2f6;">
                @php
                    $sortedHasil = $hasil;
                    usort($sortedHasil, function($a, $b) {
                        return strcmp($a['alternatif']->kode_alternatif, $b['alternatif']->kode_alternatif);
                    });
                @endphp
                @foreach($sortedHasil as $item)
                <div style="display: flex; align-items: center; padding: 10px 14px; border-bottom: 1px solid #eef2f6; 
                    @if($loop->last) border-bottom: none; @endif">
                    <div style="width: 50px; font-weight: 700; font-size: 16px; color: #4F46E5;">
                        {{ $item['alternatif']->kode_alternatif }}
                    </div>
                    <div style="flex: 1; font-weight: 600; font-size: 15px; color: #1e293b;">
                        {{ $item['alternatif']->nama_ewallet }}
                    </div>
                    <div style="font-weight: 700; font-size: 16px; color: 
                        @if($item['nilai_akhir'] >= 0.7) #10B981; 
                        @elseif($item['nilai_akhir'] >= 0.4) #F59E0B; 
                        @else #EF4444; @endif
                        min-width: 100px; text-align: right;">
                        {{ number_format($item['nilai_akhir'] * 100, 1) }}%
                    </div>
                    <div style="width: 120px; margin-left: 12px;">
                        <div class="progress" style="height: 6px; border-radius: 6px; background: #e2e8f0;">
                            <div class="progress-bar" style="width: {{ $item['nilai_akhir'] * 100 }}%; 
                                background: 
                                @if($item['nilai_akhir'] >= 0.7) linear-gradient(90deg, #10B981, #059669);
                                @elseif($item['nilai_akhir'] >= 0.4) linear-gradient(90deg, #F59E0B, #D97706);
                                @else linear-gradient(90deg, #EF4444, #DC2626); @endif
                                border-radius: 6px; transition: width 1s ease;">
                            </div>
                        </div>
                    </div>
                    <div style="min-width: 90px; text-align: right; margin-left: 8px;">
                        @if($item['nilai_akhir'] >= 0.7)
                            <span style="color: #10B981; font-size: 11px; font-weight: 600;">Tinggi</span>
                        @elseif($item['nilai_akhir'] >= 0.4)
                            <span style="color: #F59E0B; font-size: 11px; font-weight: 600;">Sedang</span>
                        @else
                            <span style="color: #EF4444; font-size: 11px; font-weight: 600;">Rendah</span>
                        @endif
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
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" style="border-radius: 12px; padding: 10px 28px; font-weight: 600;">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
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