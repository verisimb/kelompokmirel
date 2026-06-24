@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Hero / Selamat Datang - Lebih Menarik -->
<div class="row fade-in">
    <div class="col-12">
        <div class="card border-0 overflow-hidden" style="border-radius: 24px; background: linear-gradient(135deg, #4F46E5 0%, #6366F1 40%, #818CF8 70%, #A78BFA 100%); box-shadow: 0 8px 40px rgba(79,70,229,0.3); position: relative;">
            <!-- Dekorasi Elemen -->
            <div style="position: absolute; top: -60px; right: -60px; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,0.06);"></div>
            <div style="position: absolute; bottom: -80px; left: -40px; width: 160px; height: 160px; border-radius: 50%; background: rgba(255,255,255,0.04);"></div>
            <div style="position: absolute; top: 50%; right: 20%; width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.03);"></div>
            
            <div class="card-body p-4 p-md-5" style="position: relative; z-index: 1;">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <!-- Judul -->
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <h4 class="fw-bold mb-0" style="font-size: 1.8rem; color: #ffffff; letter-spacing: -0.3px; text-shadow: 0 2px 12px rgba(0,0,0,0.1);">
                                Selamat Datang di SPK E-Wallet
                            </h4>
                        </div>

                        <!-- Deskripsi -->
                        <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem; line-height: 1.7; text-align: justify; margin-top: 8px; margin-bottom: 0; max-width: 100%;">
                            <strong style="color: #ffffff;">Sistem Pendukung Keputusan (SPK)</strong> ini membantu Anda 
                            <strong style="color: #FCD34D;">memilih E-Wallet terbaik</strong> di Indonesia menggunakan metode 
                            <strong style="color: #FCD34D;">SMART</strong> (Simple Multi-Attribute Rating Technique) dengan pendekatan 
                            <strong style="color: #ffffff;">Multi-Criteria Decision Making (MCDM)</strong> yang transparan dan mudah dipahami. 
                            Evaluasi mencakup <strong style="color: #ffffff;">7 alternatif</strong> berdasarkan <strong style="color: #ffffff;">5 kriteria</strong> 
                            untuk menghasilkan keputusan objektif.
                        </p>

                        <!-- Badge -->
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="badge px-3 py-2 rounded-pill" style="font-size: 11px; font-weight: 600; background: rgba(255,255,255,0.18); color: #ffffff; border: 1px solid rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
                                <i class="bi bi-cpu me-1"></i> SPK
                            </span>
                            <span class="badge px-3 py-2 rounded-pill" style="font-size: 11px; font-weight: 600; background: rgba(252,211,77,0.2); color: #FCD34D; border: 1px solid rgba(252,211,77,0.15); backdrop-filter: blur(4px);">
                                <i class="bi bi-star-fill me-1"></i> SMART
                            </span>
                            <span class="badge px-3 py-2 rounded-pill" style="font-size: 11px; font-weight: 600; background: rgba(255,255,255,0.18); color: #ffffff; border: 1px solid rgba(255,255,255,0.15); backdrop-filter: blur(4px);">
                                <i class="bi bi-wallet2 me-1"></i> E-Wallet
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 text-center d-none d-md-block">
                        <!-- Ikon E-Wallet yang Lebih Menarik -->
                        <div style="position: relative; display: inline-block;">
                            <div style="width: 110px; height: 110px; border-radius: 50%; background: rgba(255, 255, 255, 0.1); margin: 0 auto; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 40px rgba(255,255,255,0.15), inset 0 0 40px rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.12);">
                                <i class="bi bi-wallet2" style="font-size: 52px; color: #ffffff; filter: drop-shadow(0 4px 20px rgba(255,255,255,0.3));"></i>
                            </div>
                            <div style="position: absolute; bottom: -8px; right: -8px; width: 32px; height: 32px; background: #FCD34D; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(252,211,77,0.4);">
                                <i class="bi bi-star-fill" style="font-size: 16px; color: #1a1a2e;"></i>
                            </div>
                        </div>
                        <div style="color:  #ffffff; font-size: 12px; letter-spacing: 1.5px; margin-top: 10px; font-weight: 300;">
                            SPK · SMART · E-WALLET
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik - Hanya Kriteria & Alternatif (Diperbesar) -->
<div class="row mt-3 g-3 fade-in fade-in-delay-1">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 18px; border-left: 6px solid #4F46E5; transition: transform 0.2s ease;">
            <div class="card-body d-flex align-items-center" style="padding: 20px 24px;">
                <div class="me-3" style="background: linear-gradient(135deg, #EEF2FF, #E0E7FF); width: 64px; height: 64px; border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="bi bi-list-check" style="font-size: 30px; color: #4F46E5;"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-weight: 600; font-size: 14px; letter-spacing: 0.5px;">JUMLAH KRITERIA</div>
                    <div style="font-size: 36px; font-weight: 800; color: #1a1a2e; line-height: 1.1;">{{ $jumlahKriteria ?? 0 }}</div>
                    <div style="font-size: 12px; color: #94a3b8;">Dimensi penilaian</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 18px; border-left: 6px solid #10B981; transition: transform 0.2s ease;">
            <div class="card-body d-flex align-items-center" style="padding: 20px 24px;">
                <div class="me-3" style="background: linear-gradient(135deg, #ECFDF5, #D1FAE5); width: 64px; height: 64px; border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="bi bi-people-fill" style="font-size: 30px; color: #10B981;"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-weight: 600; font-size: 14px; letter-spacing: 0.5px;">JUMLAH ALTERNATIF</div>
                    <div style="font-size: 36px; font-weight: 800; color: #1a1a2e; line-height: 1.1;">{{ $jumlahAlternatif ?? 0 }}</div>
                    <div style="font-size: 12px; color: #94a3b8;">E-Wallet dievaluasi</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Animasi Wave -->
<style>
    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(8deg); }
        75% { transform: rotate(-8deg); }
    }
</style>
@endsection