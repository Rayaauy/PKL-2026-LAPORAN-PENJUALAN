<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — UMKM Sales</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #f7f7f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-wrap { width: 100%; max-width: 400px; }
        .auth-logo { text-align: center; margin-bottom: 28px; }
        .logo-mark {
            width: 36px; height: 36px; background: #16a34a;
            border-radius: 8px; display: inline-flex;
            align-items: center; justify-content: center; margin-bottom: 10px;
        }
        .logo-mark svg { width: 17px; height: 17px; fill: white; }
        .logo-name { font-size: 15px; font-weight: 700; color: #111112; }
        .auth-card {
            background: white; border: 1px solid #e5e5e7;
            border-radius: 12px; padding: 32px;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }
        .auth-title { font-size: 20px; font-weight: 700; color: #111112; margin-bottom: 6px; }
        .auth-sub { font-size: 13.5px; color: #6e6e80; margin-bottom: 28px; }
        .field { margin-bottom: 18px; }
        .field label { display: block; font-size: 13px; font-weight: 500; color: #111112; margin-bottom: 6px; }
        .field input {
            width: 100%; padding: 9px 12px; font-size: 13.5px;
            font-family: 'Inter', sans-serif; background: white; color: #111112;
            border: 1px solid #e5e5e7; border-radius: 8px; outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .field input:focus { border-color: #16a34a; box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
        .field input.err { border-color: #ef4444; }
        .field-error { font-size: 12px; color: #ef4444; margin-top: 4px; }
        .check-row { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
        .check-row input { width: 15px; height: 15px; accent-color: #16a34a; }
        .check-row label { font-size: 13px; color: #6e6e80; }
        .btn-submit {
            width: 100%; padding: 10px; font-size: 14px; font-weight: 600;
            color: white; background: #16a34a; border: none; border-radius: 8px;
            cursor: pointer; transition: opacity .15s; margin-top: 4px;
        }
        .btn-submit:hover { opacity: .87; }
        .alert-err {
            background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5;
            border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 20px;
        }
        .auth-footer { text-align: center; font-size: 13px; color: #6e6e80; margin-top: 20px; }
        .auth-footer a { color: #16a34a; text-decoration: none; font-weight: 500; }
        .auth-footer a:hover { text-decoration: underline; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { font-size: 13px; color: #6e6e80; text-decoration: none; }
        .back-link a:hover { color: #111112; }
    </style>
</head>
<body>
    <div class="auth-wrap">
        <div class="auth-logo">
            <img src="/logo-sekolah.jpg" alt="SMK AS-SYAFI'IYAH" style="width:56px;height:56px;object-fit:contain;margin-bottom:8px;">
            <div class="logo-name" style="font-size:13px;color:#6e6e80;font-weight:600;">SMK AS-SYAFI'IYAH 01 JAKARTA</div>
            <div style="font-size:15px;font-weight:800;color:#111112;letter-spacing:-0.3px;margin-top:2px;">UMKM Sales</div>
        </div>

        <div class="auth-card">
            <div class="auth-title">Selamat datang kembali</div>
            <div class="auth-sub">Masuk untuk melanjutkan pencatatan penjualan</div>

            @if($errors->any())
                <div class="alert-err">Email atau password tidak sesuai.</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}" placeholder="nama@email.com"
                           class="{{ $errors->has('email') ? 'err' : '' }}"
                           required autofocus autocomplete="email">
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password"
                           class="{{ $errors->has('password') ? 'err' : '' }}"
                           required autocomplete="current-password">
                    @error('password')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="check-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya selama 30 hari</label>
                </div>

                <button type="submit" class="btn-submit">Masuk</button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}">Buat akun gratis</a>
            </div>
        </div>
        <div class="back-link"><a href="{{ route('home') }}">&larr; Kembali ke beranda</a></div>
    </div>
</body>
</html>
