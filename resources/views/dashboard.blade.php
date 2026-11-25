@extends('layouts.app')

@section('title', 'Dashboard')

@section('topbar-actions')
    <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Catat Transaksi
    </a>
@endsection

@section('content')
{{-- Stats row --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-label">Pendapatan Hari Ini</div>
            <div class="stat-value">Rp {{ number_format($todaySales, 0, ',', '.') }}</div>
            <div class="stat-sub">{{ now()->translatedFormat('d F Y') }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-receipt"></i></div>
            <div class="stat-label">Transaksi Bulan Ini</div>
            <div class="stat-value">{{ $monthTransactions }}</div>
            <div class="stat-sub">{{ now()->translatedFormat('F Y') }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="bi bi-graph-up"></i></div>
            <div class="stat-label">Pendapatan Bulan Ini</div>
            <div class="stat-value">Rp {{ number_format($monthSales, 0, ',', '.') }}</div>
            <div class="stat-sub">Total penjualan bulan ini</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-box-seam"></i></div>
            <div class="stat-label">Produk Aktif</div>
            <div class="stat-value">{{ $totalProducts }}</div>
            <div class="stat-sub">Produk aktif terdaftar</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-tag"></i></div>
            <div class="stat-label">Total Kategori</div>
            <div class="stat-value">{{ $totalCategories }}</div>
            <div class="stat-sub">Kategori produk</div>
        </div>
    </div>
</div>

{{-- Chart + Top products --}}
<div class="row g-3 mb-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header-clean">
                <span class="card-title">Grafik Penjualan 7 Hari Terakhir</span>
            </div>
            <div class="card-body-clean">
                <canvas id="salesChart" height="80"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header-clean">
                <span class="card-title">Produk Terlaris Bulan Ini</span>
            </div>
            @if($topProducts->count() > 0)
                <div class="card-body-clean p-0">
                    @foreach($topProducts as $i => $product)
                        <div style="padding: 11px 20px; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; justify-content: space-between; gap: 10px; @if($loop->last) border-bottom: none; @endif">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span style="width:22px; height:22px; border-radius:50%; background: #ededfe; color: var(--color-primary); font-size:11px; font-weight:600; display:flex; align-items:center; justify-content:center; flex-shrink:0;">{{ $i + 1 }}</span>
                                <span style="font-size:13.5px; color: var(--color-text);">{{ $product->name }}</span>
                            </div>
                            <span class="badge-clean badge-active">{{ $product->total_qty }} terjual</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state" style="padding: 40px 20px;">
                    <div class="empty-icon"><i class="bi bi-box"></i></div>
                    <div class="empty-desc">Belum ada data penjualan bulan ini</div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Recent transactions --}}
<div class="card">
    <div class="card-header-clean">
        <span class="card-title">Transaksi Terbaru</span>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
    </div>
    @if($recentTransactions->count() > 0)
        <div style="overflow-x: auto;">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th class="hide-mobile">Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th class="hide-mobile">Item</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $tx)
                        <tr>
                            <td class="hide-mobile">
                                <span style="font-family: monospace; font-size: 12.5px; color: var(--color-text-muted);">
                                    {{ $tx->transaction_code }}
                                </span>
                            </td>
                            <td>{{ $tx->transaction_date->format('d M Y') }}</td>
                            <td class="hide-mobile">{{ $tx->items->count() }} item</td>
                            <td style="font-weight: 600;">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</td>
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
            <div class="empty-icon"><i class="bi bi-receipt"></i></div>
            <div class="empty-title">Belum ada transaksi</div>
            <div class="empty-desc">Mulai catat transaksi penjualan pertama Anda</div>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">Catat Transaksi</a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
(function() {
    const labels = @json($salesChart->pluck('date'));
    const data   = @json($salesChart->pluck('total'));

    // Format labels to readable dates
    const formatted = labels.map(d => {
        const dt = new Date(d);
        return dt.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });

    const ctx = document.getElementById('salesChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: formatted.length ? formatted : ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Penjualan (Rp)',
                data: data.length ? data : [0,0,0,0,0,0,0],
                borderColor: '#16a34a',
                backgroundColor: 'rgba(22,163,74,0.08)',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#16a34a',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                fill: true,
                tension: 0.35
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
                        font: { size: 11 },
                        color: '#6e6e80',
                        callback: v => 'Rp ' + Number(v).toLocaleString('id-ID')
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 }, color: '#6e6e80' }
                }
            }
        }
    });
})();
</script>
@endpush
