# UMKM Sales System - Struktur Folder

Organisasi folder untuk memudahkan navigasi project.

```
umkm-sales/
├── 📁 docs/                          ← DOKUMENTASI
│   ├── 📁 PKL/                       ← 🎯 PRESENTASI PKL (MULAI DARI SINI)
│   │   ├── INDEX.html                  → Halaman utama navigasi
│   │   ├── PROJECT_OVERVIEW.html       → Ringkasan proyek lengkap
│   │   ├── ERD.html                    → Diagram database
│   │   ├── USER_FLOW.html              → Alur pengguna
│   │   ├── DATABASE_FLOW.html          → Detail alur data
│   │   ├── TECHNICAL_DOCS.md           → Dokumentasi teknis
│   │   └── README.md                   → Panduan presentasi
│   │
│   └── 📁 guides/                    ← Panduan Setup & Referensi
│       ├── README.md                   → Overview project
│       ├── QUICK_START.md              → Quick start guide
│       ├── SETUP_GUIDE.md              → Setup lengkap
│       ├── PHP_COMPATIBILITY.md        → Kompatibilitas PHP
│       ├── CHANGELOG.md                → Daftar perubahan
│       ├── UPGRADE_SUMMARY.md          → Ringkasan upgrade
│       └── FIX_SUMMARY.md              → Ringkasan perbaikan
│
├── 📁 scripts/                       ← Script Automation
│   ├── setup-database.sh               → Setup database
│   └── setup-db.sh                     → Setup DB (alternate)
│
├── 📁 app/                           ← Source Code (Laravel)
│   ├── Http/
│   │   ├── Controllers/              → Request handlers
│   │   └── Middleware/               → Authentication, etc
│   └── Models/                       → Database models
│
├── 📁 database/                      ← Database
│   ├── migrations/                   → Schema changes
│   └── seeders/                      → Dummy data
│
├── 📁 routes/                        ← URL Routes
│   └── web.php                       → Web routes
│
├── 📁 resources/                     ← Front-end Assets
│   ├── views/                        → Blade templates
│   └── css/                          → Stylesheets
│
├── 📁 public/                        ← Web Root
│   └── index.php                     → Entry point
│
├── 📁 vendor/                        ← Dependencies (auto-generated)
└── 📁 node_modules/                  ← Node packages (auto-generated)

├── 🔧 Config Files (Root)
│   ├── .env                          → Environment variables (secret)
│   ├── .env.example                  → Example env config
│   ├── .gitignore                    → Git ignore rules
│   ├── composer.json                 → PHP dependencies
│   ├── composer.lock                 → Locked versions
│   ├── package.json                  → Node dependencies
│   └── artisan                       → Laravel CLI

└── 📄 Main Files
    ├── README.md                     → Project intro (di guides/)
    └── CHANGELOG.md                  ← Version history (di guides/)
```

---

## 🎯 Untuk Presentasi PKL

### Mulai dari sini:
```bash
# Buka di browser
docs/PKL/INDEX.html
```

Atau navigasi langsung:
1. **docs/PKL/PROJECT_OVERVIEW.html** — Ringkasan umum
2. **docs/PKL/ERD.html** — Database diagram
3. **docs/PKL/USER_FLOW.html** — User flows
4. **docs/PKL/DATABASE_FLOW.html** — Technical flows
5. **docs/PKL/TECHNICAL_DOCS.md** — Reference lengkap

---

## 🚀 Untuk Development

### Setup pertama kali:
```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Setup database
bash scripts/setup-database.sh
# atau
php artisan migrate

# 4. Run server
php artisan serve
```

### Referensi:
- **docs/guides/QUICK_START.md** — Setup cepat
- **docs/guides/SETUP_GUIDE.md** — Setup lengkap
- **docs/guides/PHP_COMPATIBILITY.md** — Kompatibilitas

---

## 📁 Penjelasan Folder

| Folder | Fungsi |
|--------|--------|
| `app/` | Source code (Controllers, Models, Business Logic) |
| `database/` | Migrations & Seeders |
| `routes/` | URL routing (web.php) |
| `resources/` | Views (Blade templates) & Assets (CSS) |
| `public/` | Web root, entry point di index.php |
| `docs/PKL/` | **Dokumentasi presentasi PKL** |
| `docs/guides/` | Panduan setup & referensi teknis |
| `scripts/` | Automation scripts |

---

## ✅ Important Files at Root

```
.env               ← DO NOT COMMIT (contains secrets)
.env.example       ← Template untuk .env
composer.json      ← PHP package list
package.json       ← Node package list
artisan            ← Laravel CLI tool
```

---

**Struktur ini memudahkan:**
- ✓ Presentasi (docs/PKL/)
- ✓ Development (app/, database/, routes/)
- ✓ Setup (scripts/, docs/guides/)
- ✓ Reference (TECHNICAL_DOCS.md)