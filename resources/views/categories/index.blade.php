@extends('layouts.app')
@section('title', 'Kategori')

@section('topbar-actions')
    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Tambah Kategori
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header-clean">
        <span class="card-title">Daftar Kategori</span>
        <span style="font-size:13px; color: var(--color-text-muted);">{{ $categories->count() }} kategori</span>
    </div>
    @if($categories->count() > 0)
        <div style="overflow-x:auto;">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Produk</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td style="font-weight:500;">{{ $category->name }}</td>
                        <td style="color: var(--color-text-muted);">{{ $category->description ?? '—' }}</td>
                        <td>{{ $category->products_count ?? 0 }} produk</td>
                        <td style="text-align:right;">
                            <div style="display:flex; gap:6px; justify-content:flex-end;">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Hapus kategori {{ addslashes($category->name) }}?')">
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
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-tag"></i></div>
            <div class="empty-title">Belum ada kategori</div>
            <div class="empty-desc">Buat kategori untuk mengelompokkan produk Anda</div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
        </div>
    @endif
</div>
@endsection
