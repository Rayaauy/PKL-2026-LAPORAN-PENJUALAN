<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Sales — Aplikasi Pencatatan Penjualan untuk UMKM Indonesia</title>
    <meta name="description" content="Catat penjualan, pantau pendapatan, dan kelola produk UMKM Anda dengan mudah. Gratis, tanpa instalasi, aman, dan bisa diakses dari mana saja.">
    <meta name="keywords" content="pencatatan penjualan umkm, aplikasi kasir umkm, pembukuan umkm, catatan penjualan, laporan penjualan, aplikasi umkm gratis, kelola produk umkm">
    <meta name="author" content="SMK AS-SYAFI'IYAH 01 JAKARTA — Kelompok 4">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Open Graph -->
    <meta property="og:type"        content="website">
    <meta property="og:title"       content="UMKM Sales — Aplikasi Pencatatan Penjualan untuk UMKM Indonesia">
    <meta property="og:description" content="Catat penjualan, pantau pendapatan, dan kelola produk UMKM Anda dengan mudah. Gratis, tanpa instalasi, aman.">
    <meta property="og:url"         content="{{ url('/') }}">
    <meta property="og:site_name"   content="UMKM Sales">
    <meta property="og:locale"      content="id_ID">
    <meta property="og:image"       content="{{ url('/logo-sekolah.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="UMKM Sales — Aplikasi Pencatatan Penjualan untuk UMKM Indonesia">
    <meta name="twitter:description" content="Catat penjualan, pantau pendapatan, dan kelola produk UMKM Anda dengan mudah. Gratis dan tanpa instalasi.">
    <meta name="twitter:image"       content="{{ url('/logo-sekolah.jpg') }}">

    <!-- Structured Data: Organization -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "UMKM Sales",
        "description": "Aplikasi web pencatatan penjualan sederhana untuk pelaku UMKM Indonesia.",
        "url": "{{ url('/') }}",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Web",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "IDR"
        },
        "publisher": {
            "@type": "EducationalOrganization",
            "name": "SMK AS-SYAFI'IYAH 01 JAKARTA",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Jakarta",
                "addressCountry": "ID"
            }
        }
    }
    </script>

    <!-- Structured Data: WebSite + Sitelinks Searchbox -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "UMKM Sales",
        "url": "{{ url('/') }}",
        "inLanguage": "id",
        "potentialAction": {
            "@type": "ReadAction",
            "target": "{{ url('/blog') }}"
        }
    }
    </script>

    <!-- Breadcrumb -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {"@type": "ListItem", "position": 1, "name": "Beranda", "item": "{{ url('/') }}"}
        ]
    }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green: #16a34a;
            --green-light: #dcfce7;
            --green-dark: #15803d;
            --text: #0a0a0b;
            --muted: #6b7280;
            --border: #e5e7eb;
            --bg: #f9fafb;
            --white: #ffffff;
            --radius: 12px;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            color: var(--text);
            background: var(--white);
            overflow-x: hidden;
        }

        /* ── TICKER BAR ─────────────────────────────── */
        .ticker-bar {
            background: var(--green);
            color: white;
            height: 36px;
            display: flex;
            align-items: center;
            overflow: hidden;
            font-size: 12.5px;
            font-weight: 500;
        }

        .ticker-label {
            background: var(--green-dark);
            padding: 0 16px;
            height: 100%;
            display: flex;
            align-items: center;
            white-space: nowrap;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 11px;
            text-transform: uppercase;
            flex-shrink: 0;
        }

        .ticker-track {
            display: flex;
            animation: ticker 22s linear infinite;
            white-space: nowrap;
        }

        .ticker-item {
            padding: 0 32px;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0.92;
        }

        .ticker-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
        }

        .ticker-up { color: #bbf7d0; font-weight: 600; }

        @keyframes ticker {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* ── NAV ──────────────────────────────────────── */
        nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.94);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 0 40px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex; align-items: center; gap: 9px;
            text-decoration: none;
        }

        .nav-logo-mark {
            width: 30px; height: 30px;
            background: var(--green);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }

        .nav-logo-mark svg { width: 15px; height: 15px; fill: white; }

        .nav-logo-text {
            font-size: 15px; font-weight: 800;
            color: var(--text); letter-spacing: -0.4px;
        }

        .nav-actions { display: flex; align-items: center; gap: 10px; }

        .btn-nav-ghost {
            padding: 7px 16px; font-size: 13.5px; font-weight: 500;
            color: var(--text); background: none; border: 1px solid var(--border);
            border-radius: 8px; text-decoration: none;
            transition: background 0.15s, border-color 0.15s;
        }

        .btn-nav-ghost:hover { background: var(--bg); }

        .btn-nav-solid {
            padding: 7px 18px; font-size: 13.5px; font-weight: 600;
            color: white; background: var(--green);
            border: none; border-radius: 8px; text-decoration: none;
            transition: background 0.15s, transform 0.15s;
        }

        .btn-nav-solid:hover { background: var(--green-dark); transform: translateY(-1px); color: white; }

        /* ── HERO ─────────────────────────────────────── */
        .hero-section {
            position: relative;
            padding: 80px 40px 60px;
            overflow: hidden;
            background: linear-gradient(160deg, #f0fdf4 0%, #ffffff 55%, #f0fdf4 100%);
        }

        /* Floating coins */
        .coins-layer {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .coin {
            position: absolute;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900;
            animation: floatCoin var(--dur, 6s) ease-in-out infinite;
            animation-delay: var(--delay, 0s);
            opacity: 0.13;
            font-family: 'Inter', sans-serif;
        }

        @keyframes floatCoin {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            33%       { transform: translateY(-18px) rotate(6deg); }
            66%       { transform: translateY(10px) rotate(-4deg); }
        }

        .hero-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
        }

        .hero-left {}

        .hero-pill {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 5px 14px;
            background: var(--green-light);
            color: var(--green-dark);
            border-radius: 20px;
            font-size: 12px; font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .hero-pill-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--green);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.8); }
        }

        .hero-h1 {
            font-size: clamp(34px, 4.5vw, 58px);
            font-weight: 900;
            letter-spacing: -2.5px;
            line-height: 1.05;
            color: var(--text);
            margin-bottom: 20px;
        }

        .hero-h1 em {
            font-style: normal;
            color: var(--green);
            position: relative;
        }

        .hero-h1 em::after {
            content: '';
            position: absolute;
            bottom: 2px; left: 0; right: 0;
            height: 3px;
            background: var(--green);
            border-radius: 2px;
            opacity: 0.35;
        }

        .hero-sub {
            font-size: 16px;
            color: var(--muted);
            line-height: 1.75;
            max-width: 420px;
            margin-bottom: 32px;
        }

        .hero-actions {
            display: flex; align-items: center; gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 36px;
        }

        .btn-primary-lg {
            padding: 13px 28px;
            font-size: 14.5px; font-weight: 700;
            color: white; background: var(--green);
            border: none; border-radius: var(--radius);
            text-decoration: none; cursor: pointer;
            transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 4px 14px rgba(22,163,74,0.35);
        }

        .btn-primary-lg:hover {
            background: var(--green-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(22,163,74,0.4);
            color: white;
        }

        .btn-ghost-lg {
            padding: 13px 28px;
            font-size: 14.5px; font-weight: 600;
            color: var(--text);
            background: white;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            text-decoration: none;
            transition: border-color 0.15s, transform 0.15s;
        }

        .btn-ghost-lg:hover { border-color: #9ca3af; transform: translateY(-1px); color: var(--text); }

        /* Trust badges */
        .trust-row {
            display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
        }

        .trust-item {
            display: flex; align-items: center; gap: 6px;
            font-size: 12.5px; color: var(--muted); font-weight: 500;
        }

        .trust-check {
            width: 16px; height: 16px; border-radius: 50%;
            background: var(--green-light);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .trust-check svg { width: 9px; height: 9px; }

        /* ── HERO RIGHT — Live Dashboard Card ─────────── */
        .hero-right {
            position: relative;
        }

        .dashboard-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.09), 0 4px 16px rgba(0,0,0,0.04);
            overflow: hidden;
        }

        .dc-header {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            padding: 18px 22px 16px;
            color: white;
        }

        .dc-header-top {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 14px;
        }

        .dc-title { font-size: 11px; font-weight: 600; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.5px; }
        .dc-live { display: flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 600; opacity: 0.9; }
        .dc-live-dot { width: 6px; height: 6px; border-radius: 50%; background: #86efac; animation: blink 1.4s ease-in-out infinite; }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.3; }
        }

        .dc-amount {
            font-size: 32px; font-weight: 900; letter-spacing: -1.5px;
            line-height: 1;
        }

        .dc-amount-label { font-size: 12px; opacity: 0.75; margin-top: 4px; }

        .dc-stats {
            display: grid; grid-template-columns: 1fr 1fr 1fr;
            border-bottom: 1px solid var(--border);
        }

        .dc-stat {
            padding: 14px 18px;
            border-right: 1px solid var(--border);
        }

        .dc-stat:last-child { border-right: none; }
        .dc-stat-label { font-size: 10.5px; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 5px; }
        .dc-stat-val { font-size: 18px; font-weight: 800; letter-spacing: -0.5px; color: var(--text); }
        .dc-stat-sub { font-size: 11px; color: var(--green); font-weight: 600; margin-top: 2px; }

        .dc-chart-area {
            padding: 16px 18px 14px;
        }

        .dc-chart-label { font-size: 11px; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 12px; }

        /* Mini bar chart */
        .mini-chart {
            display: flex; align-items: flex-end; gap: 5px; height: 56px;
        }

        .mini-bar {
            flex: 1; border-radius: 4px 4px 0 0;
            background: var(--green-light);
            transition: background 0.2s;
            position: relative;
            animation: growBar 0.8s ease-out forwards;
            transform-origin: bottom;
        }

        .mini-bar.today { background: var(--green); }

        @keyframes growBar {
            from { transform: scaleY(0); }
            to   { transform: scaleY(1); }
        }

        .dc-chart-days {
            display: flex; gap: 5px; margin-top: 6px;
        }

        .dc-chart-day {
            flex: 1; text-align: center;
            font-size: 9.5px; color: var(--muted); font-weight: 500;
        }

        .dc-chart-day.today { color: var(--green); font-weight: 700; }

        /* Floating badge on card */
        .float-badge {
            position: absolute;
            background: white;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 14px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            display: flex; align-items: center; gap: 9px;
            font-size: 12.5px; font-weight: 600;
            animation: floatBadge 4s ease-in-out infinite;
        }

        .float-badge.left {
            left: -40px; top: 30%;
            animation-delay: 0.5s;
        }

        .float-badge.bottom {
            right: -30px; bottom: 20%;
            animation-delay: 1.5s;
        }

        @keyframes floatBadge {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-8px); }
        }

        .float-badge-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; flex-shrink: 0;
        }

        .float-badge-icon.green { background: var(--green-light); }
        .float-badge-icon.blue  { background: #dbeafe; }

        .float-badge-label { font-size: 10px; color: var(--muted); font-weight: 500; }
        .float-badge-val   { font-size: 13px; color: var(--text); font-weight: 700; }

        /* ── STATS COUNTER SECTION ────────────────────── */
        .counter-section {
            padding: 48px 40px;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            background: var(--white);
        }

        .counter-inner {
            max-width: 960px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 0;
        }

        .counter-item {
            padding: 20px 28px;
            border-right: 1px solid var(--border);
            text-align: center;
        }

        .counter-item:last-child { border-right: none; }

        .counter-num {
            font-size: 34px; font-weight: 900; letter-spacing: -1.5px;
            color: var(--text); line-height: 1;
            margin-bottom: 6px;
        }

        .counter-num .currency { font-size: 20px; color: var(--green); }

        .counter-label {
            font-size: 13px; color: var(--muted); font-weight: 500;
        }

        /* ── CALCULATOR SECTION ───────────────────────── */
        .calc-section {
            background: var(--bg);
            padding: 80px 40px;
        }

        .calc-inner {
            max-width: 960px; margin: 0 auto;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 60px; align-items: center;
        }

        .calc-left {}

        .calc-widget {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.07);
        }

        .calc-header {
            background: linear-gradient(135deg, #16a34a, #15803d);
            padding: 16px 20px;
            display: flex; align-items: center; justify-content: space-between;
        }

        .calc-header-title {
            font-size: 13px; font-weight: 700; color: white; letter-spacing: 0.3px;
        }

        .calc-screen-wrap {
            padding: 16px 20px 10px;
            border-bottom: 1px solid var(--border);
        }

        .calc-screen-label {
            font-size: 10.5px; color: var(--muted); font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;
        }

        .calc-screen {
            font-size: 28px; font-weight: 800; letter-spacing: -1px;
            color: var(--text); min-height: 40px; text-align: right;
            word-break: break-all;
        }

        .calc-screen.result { color: var(--green); }

        .calc-result-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 6px 20px 12px;
            font-size: 12px; color: var(--muted);
        }

        .calc-result-val { font-weight: 700; color: var(--green); font-size: 13px; }

        .calc-keys {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: var(--border);
        }

        .ckey {
            background: white;
            border: none;
            padding: 16px 10px;
            font-size: 14px; font-weight: 600;
            color: var(--text);
            cursor: pointer;
            transition: background 0.1s;
            font-family: 'Inter', sans-serif;
        }

        .ckey:hover { background: var(--bg); }
        .ckey:active { background: var(--green-light); }
        .ckey.op { color: var(--green); font-size: 16px; font-weight: 700; }
        .ckey.green { background: var(--green); color: white; font-size: 16px; }
        .ckey.green:hover { background: var(--green-dark); }
        .ckey.clear { color: #dc2626; }
        .ckey.zero { grid-column: span 2; }

        /* ── HOW IT WORKS ─────────────────────────────── */
        .steps-section {
            padding: 80px 40px;
        }

        .steps-inner {
            max-width: 960px; margin: 0 auto;
        }

        .steps-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 40px; margin-top: 48px;
        }

        .step-item {
            position: relative;
        }

        .step-num {
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--green-light);
            color: var(--green);
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; font-weight: 900;
            margin-bottom: 16px;
        }

        .step-title {
            font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 8px;
        }

        .step-desc {
            font-size: 13.5px; color: var(--muted); line-height: 1.65;
        }

        .step-connector {
            position: absolute;
            top: 20px; right: -20px;
            width: 40px; height: 2px;
            background: repeating-linear-gradient(90deg, var(--green) 0, var(--green) 5px, transparent 5px, transparent 10px);
            opacity: 0.4;
        }

        /* ── FEATURES ─────────────────────────────────── */
        .features-section {
            background: var(--bg);
            padding: 80px 40px;
        }

        .features-inner {
            max-width: 960px; margin: 0 auto;
        }

        .features-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 16px; margin-top: 48px;
        }

        .feat {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .feat:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
        }

        .feat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            background: var(--green-light);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }

        .feat-icon svg { width: 22px; height: 22px; stroke: var(--green); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .feat-title {
            font-size: 14.5px; font-weight: 700; color: var(--text); margin-bottom: 7px;
        }

        .feat-desc {
            font-size: 13px; color: var(--muted); line-height: 1.65;
        }

        /* ── CTA BANNER ───────────────────────────────── */
        .cta-section {
            padding: 80px 40px;
        }

        .cta-box {
            max-width: 960px; margin: 0 auto;
            background: linear-gradient(135deg, #16a34a 0%, #15803d 60%, #14532d 100%);
            border-radius: 20px;
            padding: 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-bg-coins {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden;
        }

        .cta-coin {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.06);
            animation: floatCoin var(--dur) ease-in-out infinite;
        }

        .cta-box h2 {
            font-size: clamp(26px, 4vw, 40px); font-weight: 900;
            letter-spacing: -1.5px; color: white; margin-bottom: 14px;
            position: relative;
        }

        .cta-box p {
            font-size: 16px; color: rgba(255,255,255,0.8);
            margin-bottom: 32px; position: relative;
        }

        .btn-cta {
            display: inline-block;
            padding: 14px 36px; font-size: 15px; font-weight: 700;
            color: var(--green); background: white;
            border-radius: var(--radius); text-decoration: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            transition: transform 0.15s, box-shadow 0.15s;
            position: relative;
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(0,0,0,0.2);
            color: var(--green-dark);
        }

        /* Section header */
        .sec-tag {
            font-size: 11.5px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: var(--green); margin-bottom: 10px;
        }

        .sec-title {
            font-size: clamp(22px, 3vw, 34px); font-weight: 900;
            letter-spacing: -1px; color: var(--text); margin-bottom: 10px;
        }

        .sec-desc {
            font-size: 15px; color: var(--muted); max-width: 480px;
        }

        /* ── FOOTER ───────────────────────────────────── */
        footer {
            padding: 24px 40px;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
        }

        .footer-logo { display: flex; align-items: center; gap: 8px; }
        .footer-logo-mark {
            width: 22px; height: 22px; background: var(--green);
            border-radius: 5px; display: flex; align-items: center; justify-content: center;
        }
        .footer-logo-mark svg { width: 11px; height: 11px; fill: white; }
        .footer-logo-text { font-size: 13px; font-weight: 700; color: var(--text); }
        .footer-text { font-size: 12.5px; color: var(--muted); }

        /* ── RESPONSIVE ───────────────────────────────── */
        @media (max-width: 900px) {
            .hero-inner   { grid-template-columns: 1fr; gap: 40px; }
            .calc-inner   { grid-template-columns: 1fr; }
            .steps-grid   { grid-template-columns: 1fr; gap: 24px; }
            .features-grid { grid-template-columns: 1fr 1fr; }
            .counter-inner { grid-template-columns: 1fr 1fr; }
            .hero-right   { display: none; }
            .float-badge  { display: none; }
        }

        @media (max-width: 600px) {
            nav { padding: 0 20px; }
            .hero-section, .calc-section, .steps-section,
            .features-section, .cta-section { padding: 60px 20px; }
            .counter-section { padding: 36px 20px; }
            .counter-inner { grid-template-columns: 1fr 1fr; }
            .features-grid { grid-template-columns: 1fr; }
            .cta-box { padding: 40px 24px; }
            footer { padding: 20px; flex-direction: column; text-align: center; }
            .step-connector { display: none; }
        }
    </style>
</head>
<body>

<!-- TICKER BAR -->
<div class="ticker-bar">
    <div class="ticker-label">Live</div>
    <div style="overflow:hidden; flex:1; display:flex;">
        <div class="ticker-track" id="tickerTrack">
            <div class="ticker-item"><div class="ticker-dot"></div> Pendapatan Hari Ini &nbsp;<span class="ticker-up" id="tickerSales">Rp 0</span></div>
            <div class="ticker-item"><div class="ticker-dot"></div> Transaksi Bulan Ini &nbsp;<span class="ticker-up">24 transaksi</span></div>
            <div class="ticker-item"><div class="ticker-dot"></div> Produk Aktif &nbsp;<span class="ticker-up">18 produk</span></div>
            <div class="ticker-item"><div class="ticker-dot"></div> Total Pendapatan Bulan &nbsp;<span class="ticker-up">Rp 4.250.000</span></div>
            <div class="ticker-item"><div class="ticker-dot"></div> Rata-rata Transaksi &nbsp;<span class="ticker-up">Rp 177.083</span></div>
            <div class="ticker-item"><div class="ticker-dot"></div> UMKM Sales &mdash; Pencatatan Penjualan Digital &nbsp;</div>
            <!-- duplicate for seamless loop -->
            <div class="ticker-item"><div class="ticker-dot"></div> Pendapatan Hari Ini &nbsp;<span class="ticker-up" id="tickerSales2">Rp 0</span></div>
            <div class="ticker-item"><div class="ticker-dot"></div> Transaksi Bulan Ini &nbsp;<span class="ticker-up">24 transaksi</span></div>
            <div class="ticker-item"><div class="ticker-dot"></div> Produk Aktif &nbsp;<span class="ticker-up">18 produk</span></div>
            <div class="ticker-item"><div class="ticker-dot"></div> Total Pendapatan Bulan &nbsp;<span class="ticker-up">Rp 4.250.000</span></div>
            <div class="ticker-item"><div class="ticker-dot"></div> Rata-rata Transaksi &nbsp;<span class="ticker-up">Rp 177.083</span></div>
            <div class="ticker-item"><div class="ticker-dot"></div> UMKM Sales &mdash; Pencatatan Penjualan Digital &nbsp;</div>
        </div>
    </div>
</div>

<!-- NAV -->
<nav>
    <a href="{{ route('home') }}" class="nav-logo">
        <div class="nav-logo-mark" style="background:none; padding:0; overflow:hidden;">
            <img src="/logo-sekolah.jpg" alt="SMK AS-SYAFI'IYAH" style="width:30px;height:30px;object-fit:contain;border-radius:6px;">
        </div>
        <span class="nav-logo-text">UMKM Sales</span>
    </a>
    <div class="nav-actions">
        <a href="{{ route('blog.index') }}" class="btn-nav-ghost">Blog</a>
        <a href="{{ route('login') }}" class="btn-nav-ghost">Masuk</a>
        <a href="{{ route('register') }}" class="btn-nav-solid">Mulai Gratis</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero-section">
    <!-- Floating coins background -->
    <div class="coins-layer">
        <div class="coin" style="width:80px;height:80px;background:#dcfce7;top:8%;left:5%;font-size:32px;color:#16a34a;--dur:7s;--delay:0s;">Rp</div>
        <div class="coin" style="width:60px;height:60px;background:#dcfce7;top:60%;left:2%;font-size:22px;color:#16a34a;--dur:5.5s;--delay:1s;">$</div>
        <div class="coin" style="width:100px;height:100px;background:#dcfce7;top:20%;right:3%;font-size:14px;color:#16a34a;--dur:8s;--delay:0.5s;">IDR</div>
        <div class="coin" style="width:70px;height:70px;background:#dcfce7;bottom:10%;right:8%;font-size:26px;color:#16a34a;--dur:6.5s;--delay:2s;">Rp</div>
        <div class="coin" style="width:50px;height:50px;background:#dcfce7;top:40%;left:8%;font-size:18px;color:#16a34a;--dur:9s;--delay:1.5s;">%</div>
    </div>

    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-pill">
                <div class="hero-pill-dot"></div>
                Sistem Pencatatan UMKM
            </div>
            <h1 class="hero-h1">Kelola <em>Keuangan</em><br>Usaha Lebih Cerdas</h1>
            <p class="hero-sub">Catat setiap penjualan, pantau pendapatan secara real-time, dan dapatkan laporan lengkap — semua dalam satu platform sederhana.</p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn-primary-lg">Mulai Gratis Sekarang</a>
                <a href="{{ route('login') }}" class="btn-ghost-lg">Masuk ke Akun</a>
            </div>
            <div class="trust-row">
                <div class="trust-item">
                    <div class="trust-check">
                        <svg viewBox="0 0 12 10" fill="none"><path d="M1 5l3.5 3.5L11 1" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    Gratis selamanya
                </div>
                <div class="trust-item">
                    <div class="trust-check">
                        <svg viewBox="0 0 12 10" fill="none"><path d="M1 5l3.5 3.5L11 1" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    Data terlindungi
                </div>
                <div class="trust-item">
                    <div class="trust-check">
                        <svg viewBox="0 0 12 10" fill="none"><path d="M1 5l3.5 3.5L11 1" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    Tanpa instalasi
                </div>
            </div>
        </div>

        <!-- Dashboard card preview -->
        <div class="hero-right">
            <!-- Floating badges -->
            <div class="float-badge left">
                <div class="float-badge-icon green" style="font-size:18px;">+</div>
                <div>
                    <div class="float-badge-label">Transaksi baru</div>
                    <div class="float-badge-val">Rp 125.000</div>
                </div>
            </div>
            <div class="float-badge bottom">
                <div class="float-badge-icon blue" style="font-size:16px;">&#x25B2;</div>
                <div>
                    <div class="float-badge-label">Naik dari kemarin</div>
                    <div class="float-badge-val" style="color:#16a34a;">+18.4%</div>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="dc-header">
                    <div class="dc-header-top">
                        <span class="dc-title">Ringkasan Penjualan</span>
                        <div class="dc-live"><div class="dc-live-dot"></div> Live</div>
                    </div>
                    <div class="dc-amount" id="heroAmount">Rp 0</div>
                    <div class="dc-amount-label">Total pendapatan hari ini</div>
                </div>

                <div class="dc-stats">
                    <div class="dc-stat">
                        <div class="dc-stat-label">Transaksi</div>
                        <div class="dc-stat-val" id="heroTx">0</div>
                        <div class="dc-stat-sub">hari ini</div>
                    </div>
                    <div class="dc-stat">
                        <div class="dc-stat-label">Produk</div>
                        <div class="dc-stat-val">18</div>
                        <div class="dc-stat-sub">aktif</div>
                    </div>
                    <div class="dc-stat">
                        <div class="dc-stat-label">Kategori</div>
                        <div class="dc-stat-val">5</div>
                        <div class="dc-stat-sub">tersedia</div>
                    </div>
                </div>

                <div class="dc-chart-area">
                    <div class="dc-chart-label">Penjualan 7 hari terakhir</div>
                    <div class="mini-chart">
                        <div class="mini-bar" style="height:38%;animation-delay:.05s"></div>
                        <div class="mini-bar" style="height:55%;animation-delay:.1s"></div>
                        <div class="mini-bar" style="height:44%;animation-delay:.15s"></div>
                        <div class="mini-bar" style="height:72%;animation-delay:.2s"></div>
                        <div class="mini-bar" style="height:61%;animation-delay:.25s"></div>
                        <div class="mini-bar" style="height:83%;animation-delay:.3s"></div>
                        <div class="mini-bar today" style="height:100%;animation-delay:.35s"></div>
                    </div>
                    <div class="dc-chart-days">
                        <div class="dc-chart-day">Sen</div>
                        <div class="dc-chart-day">Sel</div>
                        <div class="dc-chart-day">Rab</div>
                        <div class="dc-chart-day">Kam</div>
                        <div class="dc-chart-day">Jum</div>
                        <div class="dc-chart-day">Sab</div>
                        <div class="dc-chart-day today">Har</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- COUNTER SECTION -->
<div class="counter-section">
    <div class="counter-inner">
        <div class="counter-item">
            <div class="counter-num"><span class="currency">Rp </span><span class="count-num" data-target="4250000" data-prefix="Rp ">0</span></div>
            <div class="counter-label">Contoh pendapatan bulanan</div>
        </div>
        <div class="counter-item">
            <div class="counter-num"><span class="count-num" data-target="24" data-suffix="">0</span>+</div>
            <div class="counter-label">Transaksi tercatat per bulan</div>
        </div>
        <div class="counter-item">
            <div class="counter-num"><span class="count-num" data-target="18" data-suffix="">0</span></div>
            <div class="counter-label">Produk dapat dikelola</div>
        </div>
        <div class="counter-item">
            <div class="counter-num"><span class="count-num" data-target="100" data-suffix="">0</span>%</div>
            <div class="counter-label">Data terlindungi & terisolasi</div>
        </div>
    </div>
</div>

<!-- CALCULATOR SECTION -->
<section class="calc-section">
    <div class="calc-inner">
        <div class="calc-left">
            <div class="sec-tag">Kalkulator Pendapatan</div>
            <div class="sec-title">Hitung Potensi<br>Penjualan Anda</div>
            <p class="sec-desc" style="margin-bottom:24px;">Gunakan kalkulator ini untuk menghitung estimasi pendapatan harian atau bulanan usaha Anda sebelum mulai mencatat.</p>

            <div style="background:white; border:1px solid var(--border); border-radius:12px; padding:20px; margin-bottom:20px;">
                <div style="font-size:12px; color:var(--muted); font-weight:600; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:12px;">Simulasi Cepat</div>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:13.5px; color:var(--muted);">Harga produk rata-rata</span>
                        <span style="font-size:13.5px; font-weight:700;" id="simPrice">Rp 15.000</span>
                    </div>
                    <input type="range" min="1000" max="500000" step="1000" value="15000" id="simPriceRange"
                           style="width:100%; accent-color:#16a34a;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:4px;">
                        <span style="font-size:13.5px; color:var(--muted);">Transaksi per hari</span>
                        <span style="font-size:13.5px; font-weight:700;" id="simTx">10 transaksi</span>
                    </div>
                    <input type="range" min="1" max="100" step="1" value="10" id="simTxRange"
                           style="width:100%; accent-color:#16a34a;">
                    <div style="border-top:1px solid var(--border); padding-top:12px; margin-top:4px;">
                        <div style="display:flex; justify-content:space-between;">
                            <span style="font-size:13px; color:var(--muted);">Estimasi per hari</span>
                            <span style="font-size:14px; font-weight:800; color:var(--green);" id="simDay">Rp 150.000</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-top:6px;">
                            <span style="font-size:13px; color:var(--muted);">Estimasi per bulan (30 hari)</span>
                            <span style="font-size:14px; font-weight:800; color:var(--green);" id="simMonth">Rp 4.500.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculator Widget -->
        <div class="calc-widget">
            <div class="calc-header">
                <span class="calc-header-title">Kalkulator Rupiah</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"><rect x="2" y="3" width="20" height="18" rx="2"/><line x1="8" y1="21" x2="8" y2="3"/><line x1="16" y1="21" x2="16" y2="3"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
            </div>

            <div class="calc-screen-wrap">
                <div class="calc-screen-label">Perhitungan</div>
                <div class="calc-screen" id="calcExpr">&nbsp;</div>
            </div>
            <div class="calc-result-row">
                <span>Hasil</span>
                <span class="calc-result-val" id="calcResult">Rp 0</span>
            </div>

            <div class="calc-keys">
                <button class="ckey clear" onclick="calcClear()">AC</button>
                <button class="ckey op" onclick="calcOp('%')">%</button>
                <button class="ckey op" onclick="calcDel()">&#x232B;</button>
                <button class="ckey op" onclick="calcOp('/')">&#xF7;</button>

                <button class="ckey" onclick="calcNum('7')">7</button>
                <button class="ckey" onclick="calcNum('8')">8</button>
                <button class="ckey" onclick="calcNum('9')">9</button>
                <button class="ckey op" onclick="calcOp('*')">&#xD7;</button>

                <button class="ckey" onclick="calcNum('4')">4</button>
                <button class="ckey" onclick="calcNum('5')">5</button>
                <button class="ckey" onclick="calcNum('6')">6</button>
                <button class="ckey op" onclick="calcOp('-')">&#8722;</button>

                <button class="ckey" onclick="calcNum('1')">1</button>
                <button class="ckey" onclick="calcNum('2')">2</button>
                <button class="ckey" onclick="calcNum('3')">3</button>
                <button class="ckey op" style="grid-row:span 2;" onclick="calcOp('+')">+</button>

                <button class="ckey zero" onclick="calcNum('0')">0</button>
                <button class="ckey" onclick="calcDot()">.</button>

                <button class="ckey green" onclick="calcEqual()" style="grid-column:span 4;">=</button>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="steps-section">
    <div class="steps-inner">
        <div class="sec-tag">Cara Kerja</div>
        <div class="sec-title">Mulai dalam 3 Langkah</div>
        <p class="sec-desc">Tidak perlu pelatihan. Tidak perlu akuntansi. Langsung bisa digunakan.</p>

        <div class="steps-grid">
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-title">Daftar &amp; Atur Usaha</div>
                <div class="step-desc">Buat akun, isi nama usaha, tambahkan kategori dan produk yang Anda jual beserta harganya.</div>
                <div class="step-connector"></div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-title">Catat Setiap Transaksi</div>
                <div class="step-desc">Pilih produk, masukkan jumlah — sistem otomatis menghitung subtotal dan total. Simpan dalam detik.</div>
                <div class="step-connector"></div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-title">Pantau &amp; Analisis</div>
                <div class="step-desc">Dashboard menampilkan ringkasan real-time. Laporan periode bisa difilter dan diekspor ke CSV.</div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features-section">
    <div class="features-inner">
        <div class="sec-tag">Fitur Utama</div>
        <div class="sec-title">Semua yang Dibutuhkan UMKM</div>
        <p class="sec-desc">Dirancang khusus untuk pemilik usaha kecil yang ingin mencatat penjualan tanpa kerumitan teknis.</p>

        <div class="features-grid">
            <div class="feat">
                <div class="feat-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                </div>
                <div class="feat-title">Pencatatan Transaksi</div>
                <div class="feat-desc">Catat penjualan multi-produk dalam satu transaksi. Harga diambil otomatis dari database — tidak bisa dimanipulasi.</div>
            </div>
            <div class="feat">
                <div class="feat-icon">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="feat-title">Dashboard Real-time</div>
                <div class="feat-desc">Grafik penjualan 7 hari terakhir, pendapatan hari ini, dan produk terlaris — semuanya di satu halaman.</div>
            </div>
            <div class="feat">
                <div class="feat-icon">
                    <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <div class="feat-title">Laporan Periode</div>
                <div class="feat-desc">Filter laporan berdasarkan rentang tanggal. Lihat total pendapatan dan ekspor ke CSV untuk arsip.</div>
            </div>
            <div class="feat">
                <div class="feat-icon">
                    <svg viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><circle cx="12" cy="12" r="2"/></svg>
                </div>
                <div class="feat-title">Kelola Produk</div>
                <div class="feat-desc">Daftarkan produk dengan harga dan kategori. Aktifkan atau nonaktifkan tanpa menghapus histori transaksi.</div>
            </div>
            <div class="feat">
                <div class="feat-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="feat-title">Data Terlindungi</div>
                <div class="feat-desc">Setiap akun hanya bisa mengakses datanya sendiri. Ownership diperiksa di setiap request — bukan hanya di UI.</div>
            </div>
            <div class="feat">
                <div class="feat-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div class="feat-title">Export CSV</div>
                <div class="feat-desc">Download laporan transaksi dalam format CSV — bisa dibuka di Excel atau Google Sheets untuk pembukuan lanjutan.</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA BANNER -->
<section class="cta-section">
    <div class="cta-box">
        <div class="cta-bg-coins">
            <div class="cta-coin" style="width:120px;height:120px;top:-20px;left:5%;--dur:7s;"></div>
            <div class="cta-coin" style="width:80px;height:80px;bottom:-10px;left:20%;--dur:5.5s;"></div>
            <div class="cta-coin" style="width:160px;height:160px;top:10%;right:5%;--dur:8s;"></div>
            <div class="cta-coin" style="width:60px;height:60px;bottom:5%;right:25%;--dur:6s;"></div>
        </div>
        <h2>Mulai Catat Penjualan Hari Ini</h2>
        <p>Gratis. Tidak perlu kartu kredit. Tidak perlu instalasi.</p>
        <a href="{{ route('register') }}" class="btn-cta">Buat Akun Sekarang</a>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-logo" style="display:flex; align-items:center; gap:14px;">
        <img src="/logo-sekolah.jpg" alt="SMK AS-SYAFI'IYAH" style="width:44px; height:44px; object-fit:contain; border-radius:4px;">
        <div>
            <div class="footer-logo-text" style="font-size:13px;">SMK AS-SYAFI'IYAH 01 JAKARTA</div>
            <div class="footer-text" style="font-size:11.5px;">Kelompok 4 &mdash; Tahun Pelajaran 2026/2027</div>
        </div>
    </div>
    <div class="footer-logo" style="display:flex; align-items:center; gap:10px;">
        <div class="footer-logo-mark" style="background:none; padding:0; overflow:hidden;">
            <img src="/logo-sekolah.jpg" alt="Logo" style="width:22px;height:22px;object-fit:contain;border-radius:4px;">
        </div>
        <span class="footer-logo-text">UMKM Sales</span>
    </div>
    <span class="footer-text">Dibuat untuk UMKM Indonesia</span>
</footer>

<script>
// ── Animated counter ────────────────────────────────────────
function animateCount(el) {
    const target = parseInt(el.dataset.target);
    const isRp   = target > 10000;
    const dur    = 1800;
    const steps  = 60;
    const inc    = target / steps;
    let cur = 0, frame = 0;

    const timer = setInterval(() => {
        frame++;
        cur = Math.min(cur + inc * (1 + frame / steps), target);
        if (isRp) {
            el.textContent = Math.round(cur).toLocaleString('id-ID');
        } else {
            el.textContent = Math.round(cur);
        }
        if (frame >= steps) clearInterval(timer);
    }, dur / steps);
}

// Run counters when visible
const counters = document.querySelectorAll('.count-num');
const io = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) { animateCount(e.target); io.unobserve(e.target); }
    });
}, { threshold: 0.3 });

counters.forEach(c => io.observe(c));

// ── Hero amount animated up ──────────────────────────────────
(function() {
    const el  = document.getElementById('heroAmount');
    const tx  = document.getElementById('heroTx');
    let amt = 0, txc = 0;
    const finalAmt = 825000, finalTx = 7;

    function tick() {
        amt  = Math.min(amt  + 27500, finalAmt);
        txc  = Math.min(txc  + 1,     finalTx);
        el.textContent = 'Rp ' + amt.toLocaleString('id-ID');
        tx.textContent = txc;
        if (amt < finalAmt) setTimeout(tick, 80);
    }

    setTimeout(tick, 800);
})();

// ── Ticker sales ─────────────────────────────────────────────
document.getElementById('tickerSales').textContent  = 'Rp 825.000';
document.getElementById('tickerSales2').textContent = 'Rp 825.000';

// ── Simulation sliders ───────────────────────────────────────
function updateSim() {
    const price = parseInt(document.getElementById('simPriceRange').value);
    const tx    = parseInt(document.getElementById('simTxRange').value);
    const day   = price * tx;
    const month = day * 30;

    document.getElementById('simPrice').textContent  = 'Rp ' + price.toLocaleString('id-ID');
    document.getElementById('simTx').textContent     = tx + ' transaksi';
    document.getElementById('simDay').textContent    = 'Rp ' + day.toLocaleString('id-ID');
    document.getElementById('simMonth').textContent  = 'Rp ' + month.toLocaleString('id-ID');
}

document.getElementById('simPriceRange').addEventListener('input', updateSim);
document.getElementById('simTxRange').addEventListener('input', updateSim);
updateSim();

// ── Calculator ───────────────────────────────────────────────
let calcStr = '';

function calcRender() {
    const exprEl   = document.getElementById('calcExpr');
    const resultEl = document.getElementById('calcResult');
    exprEl.textContent = calcStr || '\u00a0';

    try {
        if (calcStr) {
            const val = Function('"use strict"; return (' + calcStr + ')')();
            if (isFinite(val)) {
                resultEl.textContent = 'Rp ' + Math.round(val).toLocaleString('id-ID');
            }
        } else {
            resultEl.textContent = 'Rp 0';
        }
    } catch(e) {}
}

function calcNum(n)   { calcStr += n; calcRender(); }
function calcOp(op)   { calcStr += ' ' + op + ' '; calcRender(); }
function calcDot()    { if (!calcStr.includes('.') || /[\+\-\*\/] $/.test(calcStr)) { calcStr += '.'; calcRender(); } }
function calcClear()  { calcStr = ''; calcRender(); }
function calcDel()    { calcStr = calcStr.trimEnd().slice(0, -1); calcRender(); }
function calcEqual()  {
    try {
        const val = Function('"use strict"; return (' + calcStr + ')')();
        if (isFinite(val)) {
            calcStr = String(Math.round(val * 100) / 100);
            calcRender();
        }
    } catch(e) { calcStr = ''; calcRender(); }
}
</script>
</body>
</html>
