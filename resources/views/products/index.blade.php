@extends('layouts.app')
@section('title', 'Produk')

@section('topbar-actions')
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Tambah Produk
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header-clean">
        <span class="card-title">Daftar Produk</span>
        <span style="font-size:13px; color: var(--color-text-muted);">{{ $products->total() }} produk</span>
    </div>
    @if($products->count() > 0)
        <div style="overflow-x:auto;">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th class="hide-mobile">Kategori</th>
                        <th>Harga</th>
                        <th class="hide-mobile">Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <div style="font-weight:500;">{{ $product->name }}</div>
                            @if($product->description)
                                <div style="font-size:12px; color: var(--color-text-muted);">{{ Str::limit($product->description, 60) }}</div>
                            @endif
                        </td>
                        <td style="color: var(--color-text-muted);">
                            {{ $product->category?->name ?? '—' }}
                        </td>
                        <td style="font-weight:500;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->is_active)
                                <span class="badge-clean badge-active">Aktif</span>
                            @else
                                <span class="badge-clean badge-inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex; gap:6px; justify-content:flex-end;">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
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
        @if($products->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid var(--color-border);">
                {{ $products->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-box"></i></div>
            <div class="empty-title">Belum ada produk</div>
            <div class="empty-desc">Daftarkan produk yang Anda jual untuk mulai mencatat transaksi</div>
            @if($categories->count() === 0)
                <a href="{{ route('categories.create') }}" class="btn btn-secondary" style="margin-bottom:10px;">Buat Kategori Dulu</a>
            @endif
            <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
        </div>
    @endif
</div>
@endsection
