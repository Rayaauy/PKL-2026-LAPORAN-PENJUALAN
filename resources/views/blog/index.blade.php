<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <link rel="canonical" href="{{ $seo['canonical'] }}">

    <!-- Open Graph -->
    <meta property="og:type"        content="website">
    <meta property="og:title"       content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url"         content="{{ $seo['canonical'] }}">
    <meta property="og:site_name"   content="UMKM Sales">
    <meta property="og:locale"      content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Blog",
        "name": "UMKM Sales Blog",
        "description": "{{ $seo['description'] }}",
        "url": "{{ $seo['canonical'] }}",
        "publisher": {
            "@type": "Organization",
            "name": "UMKM Sales",
            "url": "{{ url('/') }}"
        }
    }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; color: #111; background: #fff; line-height: 1.6; }
        nav {
            position: sticky; top: 0; z-index: 50;
            background: rgba(255,255,255,0.94); backdrop-filter: blur(14px);
            border-bottom: 1px solid #e5e7eb;
            padding: 0 40px; height: 56px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo { display: flex; align-items: center; gap: 9px; text-decoration: none; }
        .nav-logo img { width: 26px; height: 26px; object-fit: contain; }
        .nav-logo-text { font-size: 14px; font-weight: 800; color: #111; }
        .nav-link { font-size: 13.5px; font-weight: 500; color: #374151; text-decoration: none; padding: 6px 12px; border-radius: 8px; }
        .nav-link:hover { background: #f3f4f6; }
        .nav-link.active { color: #16a34a; font-weight: 600; }
        .btn-nav { padding: 7px 16px; font-size: 13.5px; font-weight: 600; color: white; background: #16a34a; border: none; border-radius: 8px; text-decoration: none; }
        .btn-nav:hover { background: #15803d; color: white; }

        .page-header {
            background: linear-gradient(135deg, #f0fdf4, #ffffff);
            padding: 60px 40px 48px; text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }
        .page-header h1 { font-size: clamp(28px, 4vw, 44px); font-weight: 900; letter-spacing: -1.5px; color: #111; margin-bottom: 10px; }
        .page-header p { font-size: 16px; color: #6b7280; max-width: 500px; margin: 0 auto; }

        .blog-grid-wrap { max-width: 1100px; margin: 0 auto; padding: 48px 40px; }

        .blog-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .blog-card {
            border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;
            background: white; text-decoration: none; color: inherit;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex; flex-direction: column;
        }
        .blog-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.09); }

        .blog-card-img {
            width: 100%; height: 180px; object-fit: cover;
            background: #f0fdf4; display: flex; align-items: center; justify-content: center;
            color: #9ca3af; font-size: 13px;
        }
        .blog-card-img img { width: 100%; height: 100%; object-fit: cover; }
        .blog-card-img.placeholder { background: linear-gradient(135deg, #dcfce7, #f0fdf4); }

        .blog-card-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
        .blog-card-date { font-size: 11.5px; color: #6b7280; font-weight: 500; margin-bottom: 8px; }
        .blog-card-title { font-size: 15.5px; font-weight: 700; color: #111; margin-bottom: 8px; line-height: 1.4; }
        .blog-card-excerpt { font-size: 13.5px; color: #6b7280; line-height: 1.6; flex: 1; }
        .blog-card-link { margin-top: 14px; font-size: 13px; font-weight: 600; color: #16a34a; }

        .empty { text-align: center; padding: 80px 20px; color: #9ca3af; }

        .pagination-wrap { margin-top: 40px; display: flex; justify-content: center; }

        footer { padding: 28px 40px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
        .footer-text { font-size: 12.5px; color: #9ca3af; }

        @media (max-width: 640px) {
            nav, .blog-grid-wrap, footer { padding-left: 20px; padding-right: 20px; }
            .page-header { padding: 40px 20px; }
        }
    </style>
</head>
<body>
<nav>
    <a href="{{ route('home') }}" class="nav-logo">
        <img src="/logo-sekolah.jpg" alt="Logo">
        <span class="nav-logo-text">UMKM Sales</span>
    </a>
    <div style="display:flex;align-items:center;gap:6px;">
        <a href="{{ route('home') }}"  class="nav-link">Beranda</a>
        <a href="{{ route('blog.index') }}" class="nav-link active">Blog</a>
        <a href="{{ route('login') }}"  class="btn-nav">Masuk</a>
    </div>
</nav>

<div class="page-header">
    <h1>Blog & Tips UMKM</h1>
    <p>Artikel, panduan, dan tips pencatatan penjualan untuk membantu usaha Anda berkembang.</p>
</div>

<div class="blog-grid-wrap">
    @if($posts->count() > 0)
        <div class="blog-grid">
            @foreach($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="blog-card">
                <div class="blog-card-img {{ $post->cover_image ? '' : 'placeholder' }}">
                    @if($post->cover_image)
                        <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}">
                    @else
                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:20px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            <span style="font-size:12px; color:#16a34a; font-weight:500;">Artikel</span>
                        </div>
                    @endif
                </div>
                <div class="blog-card-body">
                    <div class="blog-card-date">{{ $post->published_at->translatedFormat('d F Y') }}</div>
                    <div class="blog-card-title">{{ $post->title }}</div>
                    @if($post->excerpt)
                        <div class="blog-card-excerpt">{{ Str::limit($post->excerpt, 120) }}</div>
                    @endif
                    <div class="blog-card-link">Baca selengkapnya &rarr;</div>
                </div>
            </a>
            @endforeach
        </div>

        @if($posts->hasPages())
            <div class="pagination-wrap">{{ $posts->links() }}</div>
        @endif
    @else
        <div class="empty">
            <p style="font-size:16px; font-weight:600; color:#374151; margin-bottom:6px;">Belum ada artikel</p>
            <p>Artikel akan segera hadir.</p>
        </div>
    @endif
</div>

<footer>
    <div style="display:flex;align-items:center;gap:10px;">
        <img src="/logo-sekolah.jpg" alt="Logo" style="width:28px;height:28px;object-fit:contain;">
        <span class="footer-text">SMK AS-SYAFI'IYAH 01 JAKARTA &mdash; Kelompok 4 &mdash; 2026/2027</span>
    </div>
    <span class="footer-text">UMKM Sales &mdash; Dibuat untuk UMKM Indonesia</span>
</footer>
</body>
</html>
