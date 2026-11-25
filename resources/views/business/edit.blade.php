@extends('layouts.app')
@section('title', 'Profil Usaha')

@section('content')
<div style="max-width:560px;">
    <div class="card">
        <div class="card-header-clean">
            <span class="card-title">Profil Usaha</span>
        </div>
        <div class="card-body-clean">
            <form method="POST" action="{{ route('business.update') }}">
                @csrf @method('PUT')

                <div style="margin-bottom:18px;">
                    <label class="form-label-clean" for="business_name">Nama Usaha <span style="color:#ef4444;">*</span></label>
                    <input class="form-control-clean {{ $errors->has('business_name') ? 'is-invalid' : '' }}"
                           type="text" id="business_name" name="business_name"
                           value="{{ old('business_name', $profile?->business_name) }}"
                           placeholder="Nama usaha Anda" required autofocus>
                    @error('business_name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:18px;">
                    <label class="form-label-clean" for="owner_name">Nama Pemilik</label>
                    <input class="form-control-clean"
                           type="text" id="owner_name" name="owner_name"
                           value="{{ old('owner_name', $profile?->owner_name) }}"
                           placeholder="Nama pemilik usaha">
                </div>

                <div style="margin-bottom:18px;">
                    <label class="form-label-clean" for="phone">Nomor Telepon</label>
                    <input class="form-control-clean"
                           type="text" id="phone" name="phone"
                           value="{{ old('phone', $profile?->phone) }}"
                           placeholder="cth. 08123456789">
                </div>

                <div style="margin-bottom:18px;">
                    <label class="form-label-clean" for="address">Alamat</label>
                    <textarea class="form-control-clean" id="address" name="address"
                              rows="2" placeholder="Alamat usaha">{{ old('address', $profile?->address) }}</textarea>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="form-label-clean" for="description">Deskripsi Usaha</label>
                    <textarea class="form-control-clean" id="description" name="description"
                              rows="3" placeholder="Ceritakan singkat tentang usaha Anda">{{ old('description', $profile?->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection
