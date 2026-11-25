@extends('layouts.app')
@section('title', 'Laporan Penjualan')

@section('content')
<div class="card" style="margin-bottom:20px;">
    <div class="card-header-clean">
        <span class="card-title">Filter Periode</span>
    </div>
    <div class="card-body-clean">
        <form method="GET" action="{{ route('reports.index') }}">
            <div style="display:grid; grid-template-columns:1fr 1fr auto; gap:12px; align-items:end;">
                <div>
                    <label class="form-label-clean" for="start_date">Tanggal Mulai</label>
                    <input class="form-control-clean" type="date" id="start_date" name="start_date"
                           value="{{ $startDate }}">
                </div>
                <div>
                    <label class="form-label-clean" for="end_date">Tanggal Akhir</label>
                    <input class="form-control-clean" type="date" id="end_date" name="end_date"
                           value="{{ $endDate }}">
                </div>
                <div style="display:flex; align-items:flex-end;">
                    <button type="submit" class="btn btn-primary" style="width:100%;">Tampilkan</button>
                </div>
            </div>
            <style>
            @media (max-width: 600px) {
                .report-filter-grid { grid-template-columns: 1fr !important; }
            }
            </style>
        </form>
    </div>
</div>

{{-- Summary --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="stat-sub">Periode yang dipilih</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-receipt"></i></div>
            <div class="stat-label">Jumlah Transaksi</div>
            <div class="stat-value">{{ $totalTransactions }}</div>
            <div class="stat-sub">Transaksi tercatat</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="bi bi-graph-up"></i></div>
            <div class="stat-label">Rata-rata per Transaksi</div>
            <div class="stat-value">Rp {{ $totalTransactions > 0 ? number_format($totalRevenue / $totalTransactions, 0, ',', '.') : '0' }}</div>
            <div class="stat-sub">Nilai rata-rata</div>
        </div>
    </div>
</div>

{{-- Chart laporan --}}
@if($transactions->count() > 0)
<div class="card" style="margin-bottom:20px;">
    <div class="card-header-clean">
        <span class="card-title">Grafik Penjualan Harian</span>
    </div>
    <div class="card-body-clean">
        <canvas id="reportChart" height="60"></canvas>
    </div>
</div>
@endif

{{-- Export button --}}
@if($transactions->count() > 0)
<div style="margin-bottom:16px; display:flex; justify-content:flex-end;">
    <a href="{{ route('reports.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
       class="btn btn-secondary">
        <i class="bi bi-download"></i> Export CSV
    </a>
</div>
@endif

{{-- Transactions table --}}
<div class="card">
    <div class="card-header-clean">
        <span class="card-title">Daftar Transaksi</span>
        <span style="font-size:13px; color: var(--color-text-muted);">
            {{ $startDate }} &mdash; {{ $endDate }}
        </span>
    </div>
    @if($transactions->count() > 0)
        <div style="overflow-x:auto;">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th class="hide-mobile">Kode Transaksi</th>
                        <th class="hide-mobile">Item</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                    <tr>
                        <td>{{ $tx->transaction_date->format('d M Y') }}</td>
                        <td class="hide-mobile">
                            <span style="font-family:monospace; font-size:12px; color: var(--color-text-muted);">
                                {{ $tx->transaction_code }}
                            </span>
                        </td>
        <td class="hide-mobile" style="color:var(--color-text-muted);">{{ $tx->items_count }} item</td>
                        <td style="font-weight:600;">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('transactions.show', $tx) }}" class="btn btn-secondary btn-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-bar-chart"></i></div>
            <div class="empty-title">Tidak ada transaksi</div>
            <div class="empty-desc">Tidak ada transaksi pada periode {{ $startDate }} &mdash; {{ $endDate }}</div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
@if($transactions->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
(function() {
    // Group transactions by date
    const raw = @json($transactions->groupBy(function($tx) {
        return $tx->transaction_date->format('Y-m-d');
    })->map(function($group) {
        return $group->sum('total_amount');
    }));

    const labels = Object.keys(raw).map(d => {
        const dt = new Date(d);
        return dt.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });
    const data = Object.values(raw);

    new Chart(document.getElementById('reportChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Penjualan (Rp)',
                data,
                backgroundColor: 'rgba(22,163,74,0.15)',
                borderColor: '#16a34a',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + Number(ctx.raw).toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f1f1' },
                    ticks: {
                        font: { size: 11 }, color: '#6e6e80',
                        callback: v => 'Rp ' + Number(v).toLocaleString('id-ID')
                    }
                },
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#6e6e80' } }
            }
        }
    });
})();
</script>
@endif
@endpush
