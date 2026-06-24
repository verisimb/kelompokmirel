@extends('layouts.app')

@section('title', 'Ranking E-Wallet')
@section('page-title', '🏆 Ranking E-Wallet Terbaik')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <div class="d-flex justify-content-end align-items-center mb-4">
            <div>
                @if(!empty($hasil) && count($hasil) > 0)
                <a href="{{ route('ranking.export-pdf') }}" class="btn btn-danger" style="border-radius: 10px; padding: 8px 20px;">
                    <i class="bi bi-filetype-pdf me-1"></i> Cetak PDF
                </a>
                @endif
                <a href="{{ route('smart.index') }}" class="btn btn-primary" style="background: #4F46E5; border: none; border-radius: 10px; padding: 8px 20px;">
                    <i class="bi bi-calculator me-1"></i> Perhitungan
                </a>
            </div>
        </div>

        @if(isset($message))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle me-2"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(!empty($hasil) && count($hasil) > 0)
        <!-- TABEL RANKING -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle" id="tableRanking">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th style="border-radius: 12px 0 0 0;">Ranking</th>
                        <th>Alternatif</th>
                        <th>Nilai Akhir (V)</th>
                        <th style="border-radius: 0 12px 0 0;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasil as $item)
                    <tr class="{{ $item['ranking'] == 1 ? 'table-warning' : '' }}">
                        <td class="text-center">
                            @if($item['ranking'] == 1)
                            <span class="badge bg-warning text-dark">🏆 #1</span>
                            @elseif($item['ranking'] == 2)
                            <span class="badge bg-secondary text-white">🥈 #2</span>
                            @elseif($item['ranking'] == 3)
                            <span class="badge bg-secondary text-white" style="background: #c08457 !important;">🥉 #3</span>
                            @else
                            <span class="badge bg-light text-dark">#{{ $item['ranking'] }}</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $item['alternatif']->nama_ewallet }}</strong>
                            <br>
                            <small class="text-muted">{{ $item['alternatif']->kode_alternatif }}</small>
                        </td>
                        <td class="fw-bold text-center">{{ number_format($item['nilai_akhir'], 4) }}</td>
                        <td>
                            @if($item['ranking'] == 1)
                            <span class="text-success fw-bold">⭐ Terbaik</span>
                            @elseif($item['ranking'] == 2)
                            <span class="text-primary">Runner Up 1</span>
                            @elseif($item['ranking'] == 3)
                            <span class="text-primary">Runner Up 2</span>
                            @else
                            <span class="text-muted">Alternatif</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">
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
            order: [[0, 'asc']]
        });
    });
</script>
@endpush