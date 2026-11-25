@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('topbar-actions')
    <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Catat Transaksi
    </a>
@endsection

@section('content')
{{-- Filter --}}
<div class="card" style="margin-bottom:16px;">
    <div class="card-body-clean">
        <form method="GET" action="{{ route('transactions.index') }}">
            <div style="display:grid; grid-template-columns:1fr 1fr auto auto; gap:10px; align-items:end;">
                <div>
                    <label class="form-label-clean" for="start_date">Dari Tanggal</label>
                    <input class="form-control-clean" type="date" id="start_date" name="start_date"
                           value="{{ request('start_date') }}">
                </div>
                <div>
                    <label class="form-label-clean" for="end_date">Sampai Tanggal</label>
                    <input class="form-control-clean" type="date" id="end_date" name="end_date"
                           value="{{ request('end_date') }}">
                </div>
                <div style="display:flex; align-items:flex-end;">
                    <button type="submit" class="btn btn-primary" style="white-space:nowrap;">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
                @if(request('start_date') || request('end_date'))
                <div style="display:flex; align-items:flex-end;">
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary" style="white-space:nowrap;">Reset</a>
                </div>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header-clean">
        <span class="card-title">Riwayat Transaksi</span>
        @if(request('start_date') || request('end_date'))
            <span style="font-size:12.5px; color:var(--color-text-muted);">
                {{ request('start_date') ?? '—' }} &mdash; {{ request('end_date') ?? 'sekarang' }}
            </span>
        @endif
    </div>
    @if($transactions->count() > 0)
        <div style="overflow-x:auto;">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th class="hide-mobile">Kode</th>
                        <th>Tanggal</th>
                        <th class="hide-mobile">Item</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                    <tr>
                        <td class="hide-mobile">
                            <span style="font-family:monospace; font-size:12px; color:var(--color-text-muted);">
                                {{ $tx->transaction_code }}
                            </span>
                        </td>
                        <td>{{ $tx->transaction_date->format('d M Y') }}</td>
                        <td class="hide-mobile" style="color:var(--color-text-muted);">
                            {{ $tx->items->count() }} item
                        </td>
                        <td style="font-weight:600;">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex; gap:6px; justify-content:flex-end;">
                                <a href="{{ route('transactions.show', $tx) }}" class="btn btn-secondary btn-sm">Detail</a>
                                <form action="{{ route('transactions.destroy', $tx) }}" method="POST"
                                      onsubmit="return confirm('Hapus transaksi ini? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div style="padding:16px 20px; border-top:1px solid var(--color-border);">
                {{ $transactions->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-receipt"></i></div>
            <div class="empty-title">Belum ada transaksi</div>
            <div class="empty-desc">
                @if(request('start_date') || request('end_date'))
                    Tidak ada transaksi pada periode yang dipilih.
                @else
                    Mulai catat transaksi penjualan pertama Anda.
                @endif
            </div>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">Catat Transaksi</a>
        </div>
    @endif
</div>
@endsection
