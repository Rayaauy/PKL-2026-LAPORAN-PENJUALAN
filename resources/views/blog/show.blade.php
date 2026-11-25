<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->effective_meta_title }}</title>
    <meta name="description" content="{{ $post->effective_meta_description }}">
    @if($post->meta_keywords)
    <meta name="keywords" content="{{ $post->meta_keywords }}">
    @endif
    <link rel="canonical" href="{{ $post->canonical_url ?: url('/blog/' . $post->slug) }}">

    <!-- Open Graph -->
    <meta property="og:type"        content="{{ $post->og_type }}">
    <meta property="og:title"       content="{{ $post->effective_meta_title }}">
    <meta property="og:description" content="{{ $post->effective_meta_description }}">
    <meta property="og:url"         content="{{ url('/blog/' . $post->slug) }}">
    <meta property="og:site_name"   content="UMKM Sales">
    <meta property="og:locale"      content="id_ID">
    @if($post->effective_og_image)
    <meta property="og:image"       content="{{ asset('storage/' . $post->effective_og_image) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    @endif

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $post->effective_meta_title }}">
    <meta name="twitter:description" content="{{ $post->effective_meta_description }}">
    @if($post->effective_og_image)
    <meta name="twitter:image"       content="{{ asset('storage/' . $post->effective_og_image) }}">
    @endif

    <!-- Article Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{{ addslashes($post->title) }}",
        "description": "{{ addslashes($post->effective_meta_description) }}",
        "datePublished": "{{ $post->published_at->toIso8601String() }}",
        "dateModified": "{{ $post->updated_at->toIso8601String() }}",
        "author": {
            "@type": "Person",
            "name": "{{ addslashes($post->user->name) }}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "UMKM Sales",
            "url": "{{ url('/') }}"
        },
        "url": "{{ url('/blog/' . $post->slug) }}",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ url('/blog/' . $post->slug) }}"
        }
        @if($post->effective_og_image)
        ,"image": "{{ asset('storage/' . $post->effective_og_image) }}"
        @endif
    }
    </script>

    <!-- Breadcrumb Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {"@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ url('/') }}"},
            {"@type": "ListItem", "position": 2, "name": "Blog",    "item": "{{ url('/blog') }}"},
            {"@type": "ListItem", "position": 3, "name": "{{ addslashes($post->title) }}", "item": "{{ url('/blog/' . $post->slug) }}"}
        ]
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
        .btn-nav { padding: 7px 16px; font-size: 13.5px; font-weight: 600; color: white; background: #16a34a; border: none; border-radius: 8px; text-decoration: none; }
        .btn-nav:hover { background: #15803d; color: white; }

        .article-wrap { max-width: 740px; margin: 0 auto; padding: 48px 40px 80px; }

        .breadcrumb {
            display: flex; align-items: center; gap: 6px;
            font-size: 12.5px; color: #9ca3af; margin-bottom: 28px;
        }
        .breadcrumb a { color: #16a34a; text-decoration: none; font-weight: 500; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb-sep { color: #d1d5db; }

        .article-header { margin-bottom: 32px; }
        .article-date { font-size: 13px; color: #9ca3af; font-weight: 500; margin-bottom: 12px; }
        .article-title { font-size: clamp(26px, 4vw, 40px); font-weight: 900; letter-spacing: -1.5px; line-height: 1.15; color: #111; margin-bottom: 16px; }
        .article-excerpt { font-size: 17px; color: #6b7280; line-height: 1.7; border-left: 3px solid #16a34a; padding-left: 16px; }
        .article-author { display: flex; align-items: center; gap: 10px; margin-top: 20px; }
        .author-avatar { width: 36px; height: 36px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0; }
        .author-name { font-size: 13.5px; font-weight: 600; color: #111; }
        .author-role { font-size: 12px; color: #9ca3af; }

        .article-cover { width: 100%; border-radius: 12px; margin-bottom: 36px; max-height: 420px; object-fit: cover; }

        /* Article body typography */
        .article-body { font-size: 16px; line-height: 1.8; color: #1f2937; }
        .article-body h2 { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; color: #111; margin: 32px 0 14px; }
        .article-body h3 { font-size: 18px; font-weight: 700; color: #111; margin: 24px 0 10px; }
        .article-body p  { margin-bottom: 18px; }
        .article-body ul, .article-body ol { padding-left: 24px; margin-bottom: 18px; }
        .article-body li { margin-bottom: 6px; }
        .article-body a  { color: #16a34a; text-decoration: underline; }
        .article-body blockquote { border-left: 4px solid #16a34a; padding: 12px 20px; background: #f0fdf4; border-radius: 0 8px 8px 0; margin: 24px 0; color: #374151; font-style: italic; }
        .article-body code { background: #f3f4f6; padding: 2px 6px; border-radius: 4px; font-size: 14px; }
        .article-body pre { background: #1f2937; color: #e5e7eb; padding: 18px; border-radius: 8px; overflow-x: auto; margin: 20px 0; font-size: 14px; }
        .article-body img { max-width: 100%; border-radius: 8px; margin: 16px 0; }
        .article-body strong { font-weight: 700; }
        .article-body hr { border: none; border-top: 1px solid #e5e7eb; margin: 32px 0; }

        .article-divider { border: none; border-top: 1px solid #e5e7eb; margin: 48px 0; }

        /* Related posts */
        .related-title { font-size: 18px; font-weight: 800; letter-spacing: -0.4px; color: #111; margin-bottom: 20px; }
        .related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .related-card { border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px; text-decoration: none; color: inherit; transition: background 0.15s; }
        .related-card:hover { background: #f9fafb; }
        .related-card-date { font-size: 11px; color: #9ca3af; font-weight: 500; margin-bottom: 6px; }
        .related-card-title { font-size: 13.5px; font-weight: 600; color: #111; line-height: 1.4; }

        footer { padding: 28px 40px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
        .footer-text { font-size: 12.5px; color: #9ca3af; }

        @media (max-width: 640px) {
            nav, .article-wrap, footer { padding-left: 20px; padding-right: 20px; }
            .related-grid { grid-template-columns: 1fr; }
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
        <a href="{{ route('home') }}"       class="nav-link">Beranda</a>
        <a href="{{ route('blog.index') }}" class="nav-link">Blog</a>
        <a href="{{ route('login') }}"      class="btn-nav">Masuk</a>
    </div>
</nav>

<article class="article-wrap">
    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('blog.index') }}">Blog</a>
        <span class="breadcrumb-sep">/</span>
        <span style="color:#374151;">{{ Str::limit($post->title, 50) }}</span>
    </nav>

    <!-- Header -->
    <header class="article-header">
        <div class="article-date">{{ $post->published_at->translatedFormat('d F Y') }}</div>
        <h1 class="article-title">{{ $post->title }}</h1>
        @if($post->excerpt)
            <p class="article-excerpt">{{ $post->excerpt }}</p>
        @endif
        <div class="article-author">
            <div class="author-avatar">{{ strtoupper(substr($post->user->name, 0, 1)) }}</div>
            <div>
                <div class="author-name">{{ $post->user->name }}</div>
                <div class="author-role">Penulis &mdash; UMKM Sales</div>
            </div>
        </div>
    </header>

    <!-- Cover image -->
    @if($post->cover_image)
        <img src="{{ asset('storage/' . $post->cover_image) }}"
             alt="{{ $post->title }}"
             class="article-cover">
    @endif

    <!-- Body -->
    <div class="article-body">
        {!! $post->safe_content !!}
    </div>

    @if($related->count() > 0)
        <hr class="article-divider">
        <div class="related-title">Artikel Lainnya</div>
        <div class="related-grid">
            @foreach($related as $r)
            <a href="{{ route('blog.show', $r->slug) }}" class="related-card">
                <div class="related-card-date">{{ $r->published_at->translatedFormat('d M Y') }}</div>
                <div class="related-card-title">{{ $r->title }}</div>
            </a>
            @endforeach
        </div>
    @endif
</article>

<footer>
    <div style="display:flex;align-items:center;gap:10px;">
        <img src="/logo-sekolah.jpg" alt="Logo" style="width:28px;height:28px;object-fit:contain;">
        <span class="footer-text">SMK AS-SYAFI'IYAH 01 JAKARTA &mdash; Kelompok 4 &mdash; 2026/2027</span>
    </div>
    <a href="{{ route('blog.index') }}" style="font-size:12.5px; color:#16a34a; text-decoration:none; font-weight:600;">&larr; Kembali ke Blog</a>
</footer>
</body>
</html>
