@extends('layouts.app')

@section('title', 'Data Kriteria')
@section('page-title', 'Data Kriteria')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title fw-semibold" style="color: #1e293b;">Daftar Kriteria</h5>
            <a href="{{ route('kriteria.create') }}" class="btn btn-primary" style="background: #4F46E5; border: none; border-radius: 10px; padding: 8px 20px;">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kriteria
            </a>
        </div>

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

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="tableKriteria">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th style="border-radius: 12px 0 0 0;">No</th>
                        <th>Kode</th>
                        <th>Nama Kriteria</th>
                        <th>Bobot</th>
                        <th>Tipe</th>
                        <th>Satuan</th>
                        <th style="border-radius: 0 12px 0 0;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kriteria as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2" style="font-weight: 500;">{{ $item->kode_kriteria }}</span></td>
                        <td>{{ $item->nama_kriteria }}</td>
                        <td>{{ $item->bobot }}</td>
                        <td>
                            @if($item->tipe == 'benefit')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2" style="font-weight: 500;">Benefit</span>
                            @else
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2" style="font-weight: 500;">Cost</span>
                            @endif
                        </td>
                        <td>
                            {{-- Satuan sebagai teks biasa --}}
                            {{ $item->satuan ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('kriteria.edit', $item->id) }}" class="btn btn-warning btn-sm" style="border-radius: 8px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('kriteria.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 8px;" onclick="return confirm('Apakah Anda yakin ingin menghapus kriteria &quot;{{ $item->nama_kriteria }}&quot;?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data kriteria. Silakan tambahkan!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tableKriteria').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
            },
            pageLength: 10,
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center"lf>tip'
        });
    });
</script>
@endpush