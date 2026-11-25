@extends('layouts.app')
@section('title', 'Kelola Blog')

@section('topbar-actions')
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Artikel Baru
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header-clean">
        <span class="card-title">Manajemen Blog</span>
        <span style="font-size:13px; color:var(--color-text-muted);">{{ $posts->total() }} artikel</span>
    </div>
    @if($posts->count() > 0)
        <div style="overflow-x:auto;">
            <table class="table-clean">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>SEO</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>
                            <div style="font-weight:600;">{{ $post->title }}</div>
                            <div style="font-size:11.5px; color:var(--color-text-muted); font-family:monospace;">/blog/{{ $post->slug }}</div>
                        </td>
                        <td>
                            @if($post->status === 'published')
                                <span class="badge-clean badge-active">Dipublikasikan</span>
                            @else
                                <span class="badge-clean badge-inactive">Draft</span>
                            @endif
                        </td>
                        <td style="color:var(--color-text-muted); font-size:13px;">
                            {{ $post->published_at ? $post->published_at->format('d M Y') : '—' }}
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; align-items:center;">
                                @if($post->meta_title)
                                    <span class="badge-clean badge-active" title="Meta title tersedia">T</span>
                                @else
                                    <span class="badge-clean badge-inactive" title="Meta title kosong">T</span>
                                @endif
                                @if($post->meta_description)
                                    <span class="badge-clean badge-active" title="Meta description tersedia">D</span>
                                @else
                                    <span class="badge-clean badge-inactive" title="Meta description kosong">D</span>
                                @endif
                                @if($post->cover_image)
                                    <span class="badge-clean badge-active" title="Cover image ada">I</span>
                                @else
                                    <span class="badge-clean badge-inactive" title="Tidak ada cover image">I</span>
                                @endif
                            </div>
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex; gap:6px; justify-content:flex-end; align-items:center;">
                                @if($post->status === 'published')
                                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                                       class="btn btn-secondary btn-sm" title="Lihat di website">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('admin.blog.destroy', $post) }}" method="POST"
                                      onsubmit="return confirm('Hapus artikel ini?')">
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
        @if($posts->hasPages())
            <div style="padding:16px 20px; border-top:1px solid var(--color-border);">
                {{ $posts->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-file-earmark-text"></i></div>
            <div class="empty-title">Belum ada artikel</div>
            <div class="empty-desc">Tulis artikel pertama untuk meningkatkan SEO website</div>
            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">Buat Artikel</a>
        </div>
    @endif
</div>
@endsection
