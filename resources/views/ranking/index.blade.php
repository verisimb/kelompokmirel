@extends('layouts.app')

@section('title', 'Ranking E-Wallet')
@section('page-title', 'Ranking E-Wallet Terbaik')

@section('content')
<div class="card border-0" style="border-radius: 24px; overflow: hidden; background: #ffffff; box-shadow: none;">
    
    <!-- Header -->
    <div style="background: #f8fafc; padding: 20px 24px; border-bottom: 1px solid #eef2f6;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                <div style="background: #4F46E5; width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-trophy-fill text-white" style="font-size: 18px;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="color: #1a1a2e; font-size: 1.1rem;">Hasil Akhir Ranking</h5>
                    <p class="text-muted mb-0" style="font-size: 0.78rem;">Berdasarkan perhitungan metode SMART</p>
                </div>
            </div>
            <div>
                <a href="{{ route('smart.index') }}" class="btn btn-outline-primary btn-sm" style="border-radius: 8px; padding: 6px 16px; font-weight: 500; border-color: #4F46E5; color: #4F46E5; border-width: 1.5px;">
                    <i class="bi bi-calculator me-1"></i> Perhitungan
                </a>
            </div>
        </div>
    </div>

    <div class="card-body p-4 p-md-5">
        @if(isset($message))
        <div class="alert alert-warning" style="border-radius: 10px; border-left: 3px solid #F59E0B; padding: 10px 16px;">
            <i class="bi bi-info-circle me-2"></i> {{ $message }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger" style="border-radius: 10px; border-left: 3px solid #dc3545; padding: 10px 16px;">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
        </div>
        @endif

        @if(!empty($hasil) && count($hasil) > 0)

        <!-- Deskripsi -->
        <div style="background: #EEF2FF; border-radius: 10px; padding: 14px 20px; border-left: 4px solid #4F46E5; font-size: 0.92rem; color: #1e293b; line-height: 1.8; text-align: justify; margin-bottom: 20px;">
            <strong>Berdasarkan hasil perhitungan metode SMART,</strong>
            <span style="color: #4F46E5; font-weight: 700;">{{ $hasil[0]['alternatif']->nama_ewallet }}</span>
            memperoleh nilai akhir tertinggi sebesar <strong>{{ number_format($hasil[0]['nilai_akhir'], 4) }}</strong>,
            sehingga ditetapkan sebagai <strong>E-Wallet terbaik</strong> di antara {{ count($hasil) }} alternatif yang dievaluasi.
            Peringkat berikutnya ditempati oleh
            @if(count($hasil) > 1) <strong>{{ $hasil[1]['alternatif']->nama_ewallet }}</strong> @endif
            @if(count($hasil) > 2) dan <strong>{{ $hasil[2]['alternatif']->nama_ewallet }}</strong> @endif
            sebagai alternatif kedua dan ketiga terbaik.
        </div>

        <!-- Tabel Ranking -->
        <div class="table-responsive">
            <table class="table align-middle" id="tableRanking" style="border-collapse: collapse; font-size: 0.88rem; width: 100%;">
                <thead>
                    <tr style="border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 10px 14px; font-weight: 600; color: #475569; text-align: center; width: 70px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Ranking</th>
                        <th style="padding: 10px 14px; font-weight: 600; color: #475569; text-align: left; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Alternatif</th>
                        <th style="padding: 10px 14px; font-weight: 600; color: #475569; text-align: center; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; width: 150px;">Nilai Akhir (V)</th>
                        <th style="padding: 10px 14px; font-weight: 600; color: #475569; text-align: center; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; width: 130px;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasil as $item)
                    <tr style="border-bottom: 1px solid #f1f5f9; @if($item['ranking'] == 1) background: #EEF2FF; @endif">
                        <td class="text-center" style="padding: 10px 14px;">
                            <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; font-weight: 700; font-size: 0.8rem;
                                @if($item['ranking'] == 1) background: #4F46E5; color: #fff;
                                @else background: #f1f5f9; color: #94a3b8; @endif">
                                {{ $item['ranking'] }}
                            </span>
                        </td>
                        <td style="padding: 10px 14px;">
                            <span style="font-weight: 600; color: #1a1a2e;">{{ $item['alternatif']->nama_ewallet }}</span>
                            <span style="font-size: 0.65rem; color: #94a3b8; margin-left: 6px; background: #f1f5f9; padding: 2px 8px; border-radius: 50px;">{{ $item['alternatif']->kode_alternatif }}</span>
                        </td>
                        <td class="text-center" style="padding: 10px 14px; font-weight: @if($item['ranking'] == 1) 700 @else 500 @endif; color: @if($item['ranking'] == 1) #4F46E5 @else #1e293b @endif; font-size: 1rem;">
                            {{ number_format($item['nilai_akhir'], 4) }}
                        </td>
                        <td class="text-center" style="padding: 10px 14px;">
                            @if($item['ranking'] == 1)
                            <span style="background: #4F46E5; color: #fff; padding: 3px 14px; border-radius: 50px; font-size: 0.65rem; font-weight: 500;">
                                <i class="bi bi-star-fill me-1" style="font-size: 0.55rem;"></i> Terbaik
                            </span>
                            @else
                            <span style="color: #94a3b8; font-size: 0.7rem;">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Kesimpulan -->
        <div style="margin-top: 20px; background: #f8fafc; border-radius: 10px; padding: 14px 20px; border: 1px solid #eef2f6; font-size: 0.9rem; color: #1e293b; line-height: 1.8;">
            <div style="display: flex; align-items: flex-start; gap: 10px;">
                <div>
                    <strong>Kesimpulan:</strong>
                    <span style="color: #4F46E5; font-weight: 700;">{{ $hasil[0]['alternatif']->nama_ewallet }}</span>
                    adalah E-Wallet terbaik dengan nilai akhir <strong>{{ number_format($hasil[0]['nilai_akhir'], 4) }}</strong>.
                    @if(count($hasil) > 1)
                    Peringkat kedua: <strong>{{ $hasil[1]['alternatif']->nama_ewallet }}</strong> ({{ number_format($hasil[1]['nilai_akhir'], 4) }})
                    @endif
                    @if(count($hasil) > 2)
                    , dan peringkat ketiga: <strong>{{ $hasil[2]['alternatif']->nama_ewallet }}</strong> ({{ number_format($hasil[2]['nilai_akhir'], 4) }})
                    @endif
                    .
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="mt-3 d-flex flex-wrap gap-3 align-items-center justify-content-between">
            <div>
                <span class="text-muted" style="font-size: 0.7rem;">
                    <i class="bi bi-info-circle me-1"></i>
                    Ranking ditentukan dari nilai akhir tertinggi ke terendah
                </span>
            </div>
            <div>
                <span style="background: #EEF2FF; padding: 4px 16px; border-radius: 50px; font-weight: 500; font-size: 0.7rem; color: #4F46E5; border: 1px solid rgba(79,70,229,0.08);">
                    <i class="bi bi-trophy me-1"></i> 
                    @if(!empty($hasil) && count($hasil) > 0)
                        Juara 1: <strong style="color: #4F46E5;">{{ $hasil[0]['alternatif']->nama_ewallet }}</strong> 
                        ({{ number_format($hasil[0]['nilai_akhir'], 4) }})
                    @endif
                </span>
            </div>
        </div>

        @else
        <div class="alert alert-info" style="border-radius: 10px; border-left: 3px solid #0EA5E9; padding: 12px 18px;">
            <i class="bi bi-info-circle me-2"></i> Belum ada data ranking. Pastikan Anda sudah mengisi kriteria, alternatif, dan penilaian, lalu lakukan perhitungan SMART.
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tableRanking').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
            },
            paging: true,
            pageLength: 10,
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center"lf>tip',
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: [1, 3] }
            ]
        });
    });
</script>
@endpush