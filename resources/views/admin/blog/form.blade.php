@extends('layouts.app')
@section('title', $post ? 'Edit Artikel' : 'Artikel Baru')

@section('content')
<form method="POST"
      action="{{ $post ? route('admin.blog.update', $post) : route('admin.blog.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($post) @method('PUT') @endif

    <div class="blog-form-grid" style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">

        {{-- Left: main content --}}
        <div style="display:flex; flex-direction:column; gap:16px;">

            <div class="card">
                <div class="card-header-clean">
                    <span class="card-title">Konten Artikel</span>
                </div>
                <div class="card-body-clean">
                    <div style="margin-bottom:16px;">
                        <label class="form-label-clean" for="title">
                            Judul Artikel <span style="color:#ef4444;">*</span>
                        </label>
                        <input class="form-control-clean {{ $errors->has('title') ? 'is-invalid' : '' }}"
                               type="text" id="title" name="title"
                               value="{{ old('title', $post?->title) }}"
                               placeholder="Judul artikel yang menarik..."
                               oninput="autoSlug(this.value)"
                               required autofocus>
                        @error('title')<div class="field-error">{{ $message }}</div>@enderror
                        <div style="margin-top:6px; font-size:12px; color:var(--color-text-muted);">
                            URL: <span style="font-family:monospace; color:var(--color-primary);" id="slugPreview">/blog/{{ $post?->slug ?? '...' }}</span>
                        </div>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="form-label-clean" for="excerpt">
                            Ringkasan / Excerpt
                            <span style="color:var(--color-text-muted); font-weight:400;">(opsional — muncul di card blog)</span>
                        </label>
                        <textarea class="form-control-clean {{ $errors->has('excerpt') ? 'is-invalid' : '' }}"
                                  id="excerpt" name="excerpt" rows="2"
                                  placeholder="Ringkasan singkat artikel ini..."
                                  maxlength="500">{{ old('excerpt', $post?->excerpt) }}</textarea>
                        @error('excerpt')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label-clean" for="content">
                            Isi Artikel <span style="color:#ef4444;">*</span>
                        </label>
                        <textarea class="form-control-clean {{ $errors->has('content') ? 'is-invalid' : '' }}"
                                  id="content" name="content" rows="18"
                                  placeholder="Tulis isi artikel di sini. Mendukung HTML dasar."
                                  required>{{ old('content', $post?->content) }}</textarea>
                        @error('content')<div class="field-error">{{ $message }}</div>@enderror
                        <div style="font-size:12px; color:var(--color-text-muted); margin-top:5px;">
                            Karakter: <span id="contentCount">0</span>
                            &nbsp;&bull;&nbsp; Estimasi baca: <span id="readTime">0</span> menit
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEO Card --}}
            <div class="card">
                <div class="card-header-clean">
                    <span class="card-title">SEO &amp; Meta</span>
                    <span style="font-size:12px; color:var(--color-text-muted);">Diisi otomatis jika kosong</span>
                </div>
                <div class="card-body-clean">
                    <div style="margin-bottom:16px;">
                        <label class="form-label-clean" for="meta_title">
                            Meta Title
                            <span style="color:var(--color-text-muted); font-weight:400;">(maks. 160 karakter)</span>
                        </label>
                        <input class="form-control-clean" type="text" id="meta_title" name="meta_title"
                               value="{{ old('meta_title', $post?->meta_title) }}"
                               placeholder="Judul untuk Google Search..."
                               maxlength="160"
                               oninput="updateSeoPreview()">
                        <div style="display:flex; justify-content:space-between; margin-top:4px;">
                            <div style="font-size:11.5px; color:var(--color-text-muted);">Kosong = gunakan judul artikel + " — UMKM Sales"</div>
                            <div style="font-size:11.5px;" id="metaTitleCount">0/160</div>
                        </div>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="form-label-clean" for="meta_description">
                            Meta Description
                            <span style="color:var(--color-text-muted); font-weight:400;">(maks. 320 karakter)</span>
                        </label>
                        <textarea class="form-control-clean" id="meta_description" name="meta_description"
                                  rows="2" maxlength="320"
                                  placeholder="Deskripsi untuk Google Search..."
                                  oninput="updateSeoPreview()">{{ old('meta_description', $post?->meta_description) }}</textarea>
                        <div style="display:flex; justify-content:space-between; margin-top:4px;">
                            <div style="font-size:11.5px; color:var(--color-text-muted);">Kosong = gunakan excerpt atau 155 karakter pertama konten</div>
                            <div style="font-size:11.5px;" id="metaDescCount">0/320</div>
                        </div>
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="form-label-clean" for="meta_keywords">Kata Kunci (Keywords)</label>
                        <input class="form-control-clean" type="text" id="meta_keywords" name="meta_keywords"
                               value="{{ old('meta_keywords', $post?->meta_keywords) }}"
                               placeholder="umkm, penjualan, pencatatan, keuangan">
                    </div>

                    {{-- SERP Preview --}}
                    <div style="background:var(--color-bg); border-radius:8px; padding:16px;">
                        <div style="font-size:11.5px; font-weight:600; color:var(--color-text-muted); text-transform:uppercase; letter-spacing:0.4px; margin-bottom:10px;">Preview Google</div>
                        <div style="font-size:18px; color:#1a0dab; font-weight:400; margin-bottom:2px; line-height:1.3;" id="serpTitle">—</div>
                        <div style="font-size:13px; color:#006621; margin-bottom:4px;" id="serpUrl">umkm-sales.com/blog/...</div>
                        <div style="font-size:13px; color:#545454; line-height:1.5;" id="serpDesc">—</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right sidebar --}}
        <div style="display:flex; flex-direction:column; gap:16px;">
            {{-- Publish --}}
            <div class="card">
                <div class="card-header-clean">
                    <span class="card-title">Publikasi</span>
                </div>
                <div class="card-body-clean">
                    <div style="margin-bottom:16px;">
                        <label class="form-label-clean">Status</label>
                        <div style="display:flex; gap:12px;">
                            <label style="display:flex; align-items:center; gap:7px; font-size:13.5px; cursor:pointer;">
                                <input type="radio" name="status" value="draft"
                                       {{ old('status', $post?->status ?? 'draft') === 'draft' ? 'checked' : '' }}
                                       style="accent-color:var(--color-primary);">
                                Draft
                            </label>
                            <label style="display:flex; align-items:center; gap:7px; font-size:13.5px; cursor:pointer;">
                                <input type="radio" name="status" value="published"
                                       {{ old('status', $post?->status) === 'published' ? 'checked' : '' }}
                                       style="accent-color:var(--color-primary);">
                                Publikasikan
                            </label>
                        </div>
                    </div>

                    <div style="display:flex; gap:8px; flex-direction:column;">
                        <button type="submit" class="btn btn-primary" style="width:100%;">
                            {{ $post ? 'Simpan Perubahan' : 'Simpan Artikel' }}
                        </button>
                        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary" style="width:100%; text-align:center;">
                            Batal
                        </a>
                    </div>
                </div>
            </div>

            {{-- Cover image --}}
            <div class="card">
                <div class="card-header-clean">
                    <span class="card-title">Cover Image</span>
                </div>
                <div class="card-body-clean">
                    @if($post?->cover_image)
                        <img src="{{ asset('storage/' . $post->cover_image) }}"
                             alt="Cover"
                             style="width:100%; border-radius:8px; margin-bottom:12px; object-fit:cover; max-height:160px;">
                    @endif
                    <input type="file" name="cover_image" accept="image/jpeg,image/png,image/webp"
                           class="form-control-clean" id="coverInput"
                           onchange="previewCover(this)">
                    <div style="font-size:11.5px; color:var(--color-text-muted); margin-top:5px;">
                        JPG, PNG, WebP &bull; Maks. 2MB &bull; Rekomendasi 1200×630
                    </div>
                    <div id="coverPreview"></div>
                </div>
            </div>

            {{-- SEO Score --}}
            <div class="card">
                <div class="card-header-clean">
                    <span class="card-title">SEO Score</span>
                </div>
                <div class="card-body-clean">
                    <div id="seoChecklist" style="display:flex; flex-direction:column; gap:8px;"></div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Slug preview
function slugify(t) {
    return t.toLowerCase()
            .replace(/[^a-z0-9\s-]/g,'')
            .replace(/\s+/g,'-')
            .replace(/-+/g,'-')
            .trim();
}

function autoSlug(title) {
    document.getElementById('slugPreview').textContent = '/blog/' + (slugify(title) || '...');
    updateSeoPreview();
}

// Content count + read time
const contentEl = document.getElementById('content');
function updateContent() {
    const txt = contentEl.value;
    document.getElementById('contentCount').textContent = txt.length.toLocaleString('id-ID');
    const words = txt.trim().split(/\s+/).length;
    document.getElementById('readTime').textContent = Math.max(1, Math.ceil(words / 200));
    updateSeoChecklist();
}
contentEl.addEventListener('input', updateContent);

// Meta title/desc counters
const mtEl = document.getElementById('meta_title');
const mdEl = document.getElementById('meta_description');

function updateSeoPreview() {
    const title  = mtEl.value || (document.getElementById('title').value + ' — UMKM Sales');
    const desc   = mdEl.value || document.getElementById('excerpt').value || '...';
    const slug   = slugify(document.getElementById('title').value) || '...';

    document.getElementById('serpTitle').textContent = title.substring(0, 70) + (title.length > 70 ? '...' : '');
    document.getElementById('serpUrl').textContent   = 'umkm-sales.com/blog/' + slug;
    document.getElementById('serpDesc').textContent  = desc.substring(0, 160) + (desc.length > 160 ? '...' : '');

    document.getElementById('metaTitleCount').textContent = mtEl.value.length + '/160';
    document.getElementById('metaDescCount').textContent  = mdEl.value.length + '/320';
    updateSeoChecklist();
}

mtEl.addEventListener('input', updateSeoPreview);
mdEl.addEventListener('input', updateSeoPreview);
document.getElementById('title').addEventListener('input', updateSeoPreview);
document.getElementById('excerpt').addEventListener('input', updateSeoPreview);

// SEO checklist
function seoItem(ok, label) {
    return `<div style="display:flex;align-items:center;gap:8px;font-size:12.5px;color:${ok?'#15803d':'#9ca3af'};">
        <span style="width:16px;height:16px;border-radius:50%;background:${ok?'#dcfce7':'#f3f4f6'};display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:10px;">${ok?'&#10003;':'&#9679;'}</span>
        ${label}
    </div>`;
}

function updateSeoChecklist() {
    const title    = document.getElementById('title').value;
    const excerpt  = document.getElementById('excerpt').value;
    const mtitle   = mtEl.value;
    const mdesc    = mdEl.value;
    const content  = contentEl.value;
    const cover    = document.getElementById('coverInput').files.length > 0 || {{ $post?->cover_image ? 'true' : 'false' }};

    const checks = [
        [title.length >= 10,              'Judul minimal 10 karakter'],
        [title.length <= 70,              'Judul tidak terlalu panjang (max 70)'],
        [excerpt.length > 0,              'Excerpt diisi'],
        [content.length >= 300,           'Konten minimal 300 karakter'],
        [mtitle.length > 0,               'Meta title diisi'],
        [mtitle.length <= 60,             'Meta title ≤ 60 karakter (ideal)'],
        [mdesc.length > 0,                'Meta description diisi'],
        [mdesc.length >= 120 && mdesc.length <= 160, 'Meta description 120–160 karakter (ideal)'],
        [cover,                           'Cover image ada'],
    ];

    const score = checks.filter(c => c[0]).length;
    const pct   = Math.round(score / checks.length * 100);
    const color = pct >= 80 ? '#16a34a' : pct >= 50 ? '#f59e0b' : '#ef4444';

    document.getElementById('seoChecklist').innerHTML =
        `<div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
            <div style="flex:1;height:6px;background:#f3f4f6;border-radius:3px;overflow:hidden;">
                <div style="height:100%;width:${pct}%;background:${color};border-radius:3px;transition:width .3s;"></div>
            </div>
            <span style="font-size:13px;font-weight:700;color:${color};">${pct}%</span>
        </div>` +
        checks.map(c => seoItem(c[0], c[1])).join('');
}

// Cover preview
function previewCover(input) {
    if (!input.files.length) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('coverPreview').innerHTML =
            `<img src="${e.target.result}" style="width:100%;border-radius:8px;margin-top:10px;object-fit:cover;max-height:140px;" alt="Preview">`;
    };
    reader.readAsDataURL(input.files[0]);
    updateSeoChecklist();
}

// Init
updateContent();
updateSeoPreview();
</script>
@endpush
