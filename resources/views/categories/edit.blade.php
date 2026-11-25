@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<div style="max-width:540px;">
    <div class="card">
        <div class="card-header-clean">
            <span class="card-title">Edit Kategori</span>
        </div>
        <div class="card-body-clean">
            <form method="POST" action="{{ route('categories.update', $category) }}">
                @csrf @method('PUT')
                <div style="margin-bottom:18px;">
                    <label class="form-label-clean" for="name">Nama Kategori <span style="color:#ef4444;">*</span></label>
                    <input class="form-control-clean {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           type="text" id="name" name="name"
                           value="{{ old('name', $category->name) }}" required autofocus>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label-clean" for="description">Deskripsi <span style="color:var(--color-text-muted); font-weight:400;">(opsional)</span></label>
                    <textarea class="form-control-clean" id="description" name="description"
                              rows="3">{{ old('description', $category->description) }}</textarea>
                </div>

                <div style="display:flex; gap:10px;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
