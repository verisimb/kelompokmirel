@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="fade-in">

    {{-- ============================================================ --}}
    {{-- BREADCRUMB --}}
    {{-- ============================================================ --}}
    <div style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 16px; padding-left: 2px;">
        <i class="bi bi-house-door me-1" style="font-size: 0.7rem;"></i>
        <span style="color: #4F46E5; font-weight: 500;">Sistem Pendukung Keputusan</span>
    </div>

{{-- ============================================================ --}}
{{-- HEADER (SPK E-Wallet + Logo di Tengah Area Kosong) --}}
{{-- ============================================================ --}}
<div style="background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 60%, #C7D2FE 100%); border-radius: 16px; padding: 24px 28px; border: 1px solid rgba(79,70,229,0.08); margin-bottom: 24px; display: flex; align-items: center; flex-wrap: wrap; gap: 16px;">

    {{-- TEKS (max-width 70% agar ada ruang kosong di kanan) --}}
    <div style="flex: 0 1 70%; min-width: 240px;">
        <h4 style="font-size: 1.5rem; font-weight: 700; color: #1a1a2e; margin: 0 0 6px 0;">
            SPK E-Wallet
        </h4>
        <p style="font-size: 0.88rem; color: #334155; line-height: 1.8; margin: 0 0 12px 0; text-align: justify;">
            SPK E-Wallet dirancang untuk membantu Anda menemukan dompet digital terbaik sesuai kebutuhan. 
            Metode SMART yang digunakan memastikan setiap kriteria penilaian diperhitungkan secara proporsional dan transparan. 
            Sistem ini mengevaluasi berbagai alternatif E-Wallet berdasarkan data objektif, bukan sekadar preferensi subjektif. 
            Dengan pendekatan MCDM, Anda mendapatkan rekomendasi yang terstruktur dan mudah dipahami. 
            Hasil akhirnya adalah keputusan yang akurat, andal, dan siap digunakan sebagai acuan.
        </p>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <span style="background: rgba(79,70,229,0.15); color: #4F46E5; padding: 2px 16px; border-radius: 50px; font-size: 10px; font-weight: 600; border: 1px solid rgba(79,70,229,0.1);">SMART</span>
            <span style="background: rgba(79,70,229,0.15); color: #4F46E5; padding: 2px 16px; border-radius: 50px; font-size: 10px; font-weight: 600; border: 1px solid rgba(79,70,229,0.1);">E-Wallet</span>
            <span style="background: rgba(79,70,229,0.10); color: #4F46E5; padding: 2px 16px; border-radius: 50px; font-size: 10px; font-weight: 600; border: 1px solid rgba(79,70,229,0.08);">MCDM</span>
        </div>
    </div>

    {{-- LOGO (berada di area kosong 30% sisanya, tepat di tengah-tengah) --}}
    <div style="flex: 0 1 27%; display: flex; justify-content: center; align-items: center; min-width: 100px;">
        <div style="text-align: center; animation: float 3s ease-in-out infinite;">
            <div style="background: rgba(79,70,229,0.08); width: 150px; height: 150px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid rgba(79,70,229,0.1); backdrop-filter: blur(4px);">
                <i class="bi bi-wallet2" style="font-size: 60px; color: #4F46E5;"></i>
            </div>
            <div style="font-size: 0.60rem; color: #4F46E5; font-weight: 600; margin-top: 6px; letter-spacing: 1.2px;">E-WALLET</div>
        </div>
    </div>
</div>

    {{-- ============================================================ --}}
    {{-- STATISTIK 3 KOLOM --}}
    {{-- ============================================================ --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div style="background: #ffffff; border-radius: 14px; padding: 18px 22px; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 10px; color: #94a3b8; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">Kriteria</div>
                    <div style="font-size: 32px; font-weight: 700; color: #1a1a2e; line-height: 1.2;">{{ $jumlahKriteria ?? 0 }}</div>
                    <div style="font-size: 11px; color: #94a3b8;">Total kriteria evaluasi</div>
                </div>
                <div style="background: #EEF2FF; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-list-check" style="font-size: 22px; color: #4F46E5;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div style="background: #ffffff; border-radius: 14px; padding: 18px 22px; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 10px; color: #94a3b8; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">Alternatif</div>
                    <div style="font-size: 32px; font-weight: 700; color: #1a1a2e; line-height: 1.2;">{{ $jumlahAlternatif ?? 0 }}</div>
                    <div style="font-size: 11px; color: #94a3b8;">Total alternatif</div>
                </div>
                <div style="background: #ECFDF5; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-people-fill" style="font-size: 22px; color: #10B981;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div style="background: #ffffff; border-radius: 14px; padding: 18px 22px; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 10px; color: #94a3b8; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">Penilaian</div>
                    <div style="font-size: 32px; font-weight: 700; color: #1a1a2e; line-height: 1.2;">{{ $jumlahPenilaian ?? 0 }}</div>
                    <div style="font-size: 11px; color: #94a3b8;">Total penilaian</div>
                </div>
                <div style="background: #FFFBEB; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-pencil-square" style="font-size: 22px; color: #F59E0B;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- ALTERNATIF TERBAIK --}}
    {{-- ============================================================ --}}
    <div style="background: #ffffff; border-radius: 14px; padding: 18px 24px; border: 1px solid #f1f5f9; margin-bottom: 24px;">
        <div style="font-size: 10px; color: #94a3b8; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 6px;">
            <span style="color: #F59E0B; font-size: 12px;">★</span> Alternatif Terbaik
        </div>
        <div style="display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap;">
            <span style="font-size: 26px; font-weight: 700; color: #1a1a2e;">
                @if(!empty($chartData['labels'][0] ?? null))
                    {{ $chartData['labels'][0] }}
                @else
                    —
                @endif
            </span>
            <span style="font-size: 18px; font-weight: 600; color: #4F46E5; background: #EEF2FF; padding: 2px 18px; border-radius: 50px; border: 1px solid #E0E7FF;">
                @if(!empty($chartData['data'][0] ?? null))
                    {{ number_format($chartData['data'][0] / 100, 4) }}
                @else
                    —
                @endif
            </span>
        </div>
        <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">
            Nilai preferensi tertinggi berdasarkan perhitungan metode SMART
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TOMBOL AKSI 3 KOLOM --}}
    {{-- ============================================================ --}}
    <div class="row g-3">
        <div class="col-md-4">
            <a href="{{ route('ranking.index') }}" style="display: block; background: #ffffff; border-radius: 14px; padding: 16px 22px; border: 1px solid #f1f5f9; text-decoration: none; transition: all 0.2s ease;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 10px; color: #94a3b8; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">Lihat Semua</div>
                        <div style="font-size: 15px; font-weight: 600; color: #1a1a2e;">Ranking E-Wallet</div>
                    </div>
                    <div style="background: #EEF2FF; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-chevron-right" style="font-size: 18px; color: #4F46E5;"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('smart.index') }}" style="display: block; background: #ffffff; border-radius: 14px; padding: 16px 22px; border: 1px solid #f1f5f9; text-decoration: none; transition: all 0.2s ease;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 10px; color: #94a3b8; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">Lihat Semua</div>
                        <div style="font-size: 15px; font-weight: 600; color: #1a1a2e;">Perhitungan SMART</div>
                    </div>
                    <div style="background: #EEF2FF; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-chevron-right" style="font-size: 18px; color: #4F46E5;"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('penilaian.index') }}" style="display: block; background: #ffffff; border-radius: 14px; padding: 16px 22px; border: 1px solid #f1f5f9; text-decoration: none; transition: all 0.2s ease;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 10px; color: #94a3b8; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase;">Kelola Penilaian</div>
                        <div style="font-size: 15px; font-weight: 600; color: #1a1a2e;">Input Nilai Alternatif</div>
                    </div>
                    <div style="background: #EEF2FF; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-chevron-right" style="font-size: 18px; color: #4F46E5;"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

</div>

{{-- Animasi Float --}}
<style>
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
        100% { transform: translateY(0px); }
    }
</style>

@endsection