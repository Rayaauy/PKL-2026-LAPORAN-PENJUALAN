@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('topbar-actions')
    <button onclick="window.print()" class="btn btn-secondary btn-sm">
        <i class="bi bi-printer"></i> Cetak
    </button>
@endsection

@push('styles')
<style>
@media print {
    .sidebar, .topbar, .btn, .no-print { display: none !important; }
    .main-wrapper { margin-left: 0 !important; }
    .page-content { padding: 0 !important; }
    .card { border: none !important; box-shadow: none !important; }
    .print-header { display: block !important; }
}
.print-header { display: none; }
</style>
@endpush

@section('content')
<div style="max-width:660px;">

    {{-- Print header (hidden on screen) --}}
    <div class="print-header" style="text-align:center; margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid #e5e7eb;">
        <img src="/logo-sekolah.jpg" style="width:48px; height:48px; object-fit:contain; margin-bottom:8px;" alt="Logo">
        <div style="font-size:18px; font-weight:800; color:#111;">UMKM Sales</div>
        <div style="font-size:12px; color:#6b7280;">Bukti Transaksi Penjualan</div>
    </div>

    <div class="no-print" style="margin-bottom:20px; display:flex; gap:10px;">
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header-clean">
            <div>
                <div class="card-title">Detail Transaksi</div>
                <div style="font-family:monospace; font-size:12px; color:var(--color-text-muted); margin-top:3px;">
                    {{ $transaction->transaction_code }}
                </div>
            </div>
            <span class="badge-clean badge-success">Selesai</span>
        </div>
        <div class="card-body-clean">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
                <div>
                    <div style="font-size:11.5px; font-weight:600; color:var(--color-text-muted); text-transform:uppercase; letter-spacing:0.4px; margin-bottom:4px;">Tanggal</div>
                    <div style="font-size:14px; font-weight:500;">{{ $transaction->transaction_date->format('d F Y') }}</div>
                </div>
                <div>
                    <div style="font-size:11.5px; font-weight:600; color:var(--color-text-muted); text-transform:uppercase; letter-spacing:0.4px; margin-bottom:4px;">Total</div>
                    <div style="font-size:20px; font-weight:700; color:var(--color-primary);">
                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <div style="font-size:12px; font-weight:600; color:var(--color-text-muted); text-transform:uppercase; letter-spacing:0.4px; margin-bottom:12px;">Item Transaksi</div>

            <table class="table-clean" style="border:1px solid var(--color-border); border-radius:10px; overflow:hidden; width:100%;">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align:right;">Harga</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->items as $item)
                    <tr>
                        <td style="font-weight:500;">{{ $item->product_name }}</td>
                        <td style="text-align:right; color:var(--color-text-muted);">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:right; font-weight:600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right; font-weight:700; padding:14px 16px; border-top:2px solid var(--color-border);">Total</td>
                        <td style="text-align:right; font-weight:700; color:var(--color-primary); padding:14px 16px; border-top:2px solid var(--color-border);">
                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            @if($transaction->notes)
                <div style="margin-top:20px; padding:14px 16px; background:var(--color-bg); border-radius:8px;">
                    <div style="font-size:12px; font-weight:600; color:var(--color-text-muted); margin-bottom:4px;">Catatan</div>
                    <div style="font-size:13.5px;">{{ $transaction->notes }}</div>
                </div>
            @endif

            {{-- Print footer --}}
            <div class="print-header" style="margin-top:32px; text-align:center; padding-top:16px; border-top:1px solid #e5e7eb; font-size:11px; color:#9ca3af;">
                Dicetak pada {{ now()->format('d M Y, H:i') }} WIB &mdash; UMKM Sales
            </div>
        </div>
    </div>
</div>
@endsection
