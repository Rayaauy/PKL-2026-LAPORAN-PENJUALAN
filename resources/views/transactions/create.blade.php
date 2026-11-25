@extends('layouts.app')
@section('title', 'Catat Transaksi')

@section('content')
<div style="max-width:680px;">
    <div class="card">
        <div class="card-header-clean">
            <span class="card-title">Transaksi Baru</span>
        </div>
        <div class="card-body-clean">
            @if($products->count() === 0)
                <div class="alert-clean alert-error-clean">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Belum ada produk aktif. <a href="{{ route('products.create') }}" style="color:inherit; font-weight:600;">Tambah produk</a> terlebih dahulu.</span>
                </div>
            @else
            <form method="POST" action="{{ route('transactions.store') }}" id="transaction-form">
                @csrf

                <div style="margin-bottom:20px;">
                    <label class="form-label-clean" for="transaction_date">Tanggal Transaksi <span style="color:#ef4444;">*</span></label>
                    <input class="form-control-clean {{ $errors->has('transaction_date') ? 'is-invalid' : '' }}"
                           type="date" id="transaction_date" name="transaction_date"
                           value="{{ old('transaction_date', now()->format('Y-m-d')) }}" required>
                    @error('transaction_date')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Product picker --}}
                <div style="background: var(--color-bg); border-radius: 10px; padding: 18px; margin-bottom: 20px;">
                    <div style="font-size:13px; font-weight:600; color: var(--color-text-muted); text-transform:uppercase; letter-spacing:0.4px; margin-bottom:14px;">Tambah Item</div>

                    <div style="display:grid; grid-template-columns: 1fr 100px auto; gap:10px; align-items:end;">
                        <div>
                            <label class="form-label-clean" for="product_select">Produk</label>
                            <select class="form-control-clean" id="product_select">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}">
                                        {{ $product->name }} — Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label-clean" for="qty_input">Jumlah</label>
                            <input class="form-control-clean" type="number"
                                   id="qty_input" min="1" value="1" placeholder="1">
                        </div>
                        <div style="display:flex; align-items:flex-end;">
                            <button type="button" class="btn btn-primary" onclick="addItem()" style="width:100%; white-space:nowrap;">+ Tambah</button>
                        </div>
                    </div>

                    <style>
                    @media (max-width: 540px) {
                        #picker-grid { grid-template-columns: 1fr !important; }
                    }
                    </style>

                    <div id="add-error" style="color:#ef4444; font-size:12px; margin-top:8px; display:none;"></div>
                </div>

                {{-- Item list --}}
                <div id="items-container">
                    <div id="empty-items" style="text-align:center; padding:24px; color: var(--color-text-muted); font-size:13.5px; border: 1.5px dashed var(--color-border); border-radius:10px;">
                        Belum ada item ditambahkan
                    </div>
                    <div id="items-table" style="display:none;">
                        <table class="table-clean" style="border:1px solid var(--color-border); border-radius:10px; overflow:hidden;">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th style="text-align:right;">Harga</th>
                                    <th style="text-align:center;">Qty</th>
                                    <th style="text-align:right;">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="items-body"></tbody>
                        </table>
                    </div>
                </div>

                {{-- Total --}}
                <div style="margin-top:20px; padding:16px 20px; background: var(--color-bg); border-radius:10px; display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:14px; font-weight:600; color: var(--color-text);">Total Transaksi</span>
                    <span id="total-display" style="font-size:20px; font-weight:700; color: var(--color-primary);">Rp 0</span>
                </div>

                <div style="margin-top:16px; margin-bottom:24px;">
                    <label class="form-label-clean" for="notes">Catatan <span style="color:var(--color-text-muted); font-weight:400;">(opsional)</span></label>
                    <textarea class="form-control-clean" id="notes" name="notes"
                              rows="2" placeholder="Catatan tambahan untuk transaksi ini">{{ old('notes') }}</textarea>
                </div>

                <div id="items-hidden"></div>

                <div style="display:flex; gap:10px;">
                    <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                        <i class="bi bi-check"></i> Simpan Transaksi
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const items = [];

function fmt(n) {
    return 'Rp ' + Number(n).toLocaleString('id-ID');
}

function renderItems() {
    const tbody = document.getElementById('items-body');
    const hidden = document.getElementById('items-hidden');
    const empty  = document.getElementById('empty-items');
    const table  = document.getElementById('items-table');
    const submit = document.getElementById('submit-btn');

    tbody.innerHTML = '';
    hidden.innerHTML = '';
    let total = 0;

    items.forEach((it, i) => {
        total += it.subtotal;
        tbody.innerHTML += `
            <tr>
                <td>${it.name}</td>
                <td style="text-align:right;">${fmt(it.price)}</td>
                <td style="text-align:center;">${it.qty}</td>
                <td style="text-align:right; font-weight:600;">${fmt(it.subtotal)}</td>
                <td style="text-align:right;">
                    <button type="button" onclick="removeItem(${i})"
                        style="background:none; border:none; color:#ef4444; cursor:pointer; font-size:16px; padding:2px 6px;">&times;</button>
                </td>
            </tr>`;

        hidden.innerHTML += `
            <input type="hidden" name="items[${i}][product_id]" value="${it.id}">
            <input type="hidden" name="items[${i}][quantity]"   value="${it.qty}">`;
    });

    document.getElementById('total-display').textContent = fmt(total);
    empty.style.display  = items.length ? 'none' : 'block';
    table.style.display  = items.length ? 'block' : 'none';
    submit.disabled      = items.length === 0;
}

function addItem() {
    const sel = document.getElementById('product_select');
    const qty = parseInt(document.getElementById('qty_input').value);
    const err = document.getElementById('add-error');

    err.style.display = 'none';

    if (!sel.value) {
        err.textContent = 'Pilih produk terlebih dahulu.';
        err.style.display = 'block'; return;
    }
    if (!qty || qty < 1) {
        err.textContent = 'Jumlah harus minimal 1.';
        err.style.display = 'block'; return;
    }

    const opt   = sel.options[sel.selectedIndex];
    const price = parseFloat(opt.dataset.price);
    const id    = parseInt(sel.value);
    const name  = opt.dataset.name;

    const existing = items.findIndex(x => x.id === id);
    if (existing >= 0) {
        items[existing].qty     += qty;
        items[existing].subtotal = items[existing].price * items[existing].qty;
    } else {
        items.push({ id, name, price, qty, subtotal: price * qty });
    }

    sel.value = '';
    document.getElementById('qty_input').value = 1;
    renderItems();
}

function removeItem(i) {
    items.splice(i, 1);
    renderItems();
}

renderItems();
</script>
@endpush
