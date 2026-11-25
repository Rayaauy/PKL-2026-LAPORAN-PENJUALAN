@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<div style="max-width:560px;">
    <div class="card">
        <div class="card-header-clean">
            <span class="card-title">Tambah Produk</span>
        </div>
        <div class="card-body-clean">
            @if($categories->count() === 0)
                <div class="alert-clean alert-error-clean">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Belum ada kategori. <a href="{{ route('categories.create') }}" style="color:inherit; font-weight:600;">Buat kategori</a> terlebih dahulu sebelum menambah produk.</span>
                </div>
            @endif

            <form method="POST" action="{{ route('products.store') }}">
                @csrf
                <div style="margin-bottom:18px;">
                    <label class="form-label-clean" for="name">Nama Produk <span style="color:#ef4444;">*</span></label>
                    <input class="form-control-clean {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           type="text" id="name" name="name"
                           value="{{ old('name') }}" placeholder="cth. Es Teh Manis" required autofocus>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:18px;">
                    <label class="form-label-clean" for="category_id">Kategori <span style="color:#ef4444;">*</span></label>
                    <select class="form-control-clean {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                            id="category_id" name="category_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:18px;">
                    <label class="form-label-clean" for="price">Harga Jual <span style="color:#ef4444;">*</span></label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color: var(--color-text-muted); font-size:13px;">Rp</span>
                        <input class="form-control-clean {{ $errors->has('price') ? 'is-invalid' : '' }}"
                               type="number" id="price" name="price"
                               value="{{ old('price') }}" placeholder="5000"
                               min="0" step="100" required
                               style="padding-left:36px;">
                    </div>
                    @error('price')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:18px;">
                    <label class="form-label-clean" for="description">Deskripsi <span style="color:var(--color-text-muted); font-weight:400;">(opsional)</span></label>
                    <textarea class="form-control-clean" id="description" name="description"
                              rows="2" placeholder="Keterangan produk">{{ old('description') }}</textarea>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label-clean">Status</label>
                    <div style="display:flex; gap:16px;">
                        <label style="display:flex; align-items:center; gap:7px; font-size:13.5px; cursor:pointer;">
                            <input type="radio" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} style="accent-color:#16a34a;">
                            Aktif
                        </label>
                        <label style="display:flex; align-items:center; gap:7px; font-size:13.5px; cursor:pointer;">
                            <input type="radio" name="is_active" value="0" {{ old('is_active') == '0' ? 'checked' : '' }} style="accent-color:#16a34a;">
                            Nonaktif
                        </label>
                    </div>
                </div>

                <div style="display:flex; gap:10px;">
                    <button type="submit" class="btn btn-primary" {{ $categories->count() === 0 ? 'disabled' : '' }}>Simpan Produk</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
