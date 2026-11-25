# 🎯 START HERE - UMKM Sales System PKL

**Dokumentasi PKL siap untuk presentasi!**

---

## ⚡ Quick Start (5 menit)

### 1. Buka Presentasi
```bash
# Buka di browser
docs/PKL/INDEX.html
```

### 2. Navigasi Dokumentasi
- **INDEX.html** → Halaman utama (mulai dari sini)
- **PROJECT_OVERVIEW.html** → Ringkasan proyek
- **ERD.html** → Database diagram
- **USER_FLOW.html** → Alur pengguna
- **DATABASE_FLOW.html** → Detail data flow
- **TECHNICAL_DOCS.md** → Referensi teknis

### 3. Folder Terorganisir
```
docs/
├── PKL/          ← 🎯 Presentasi (mulai dari sini)
├── guides/       ← Setup guide & referensi
└── FOLDER_OVERVIEW.html  ← Visualisasi struktur
```

---

## 📚 Dokumentasi Lengkap

| Tujuan | File | Lokasi |
|--------|------|--------|
| **Presentasi Utama** | INDEX.html | `docs/PKL/` |
| Ringkasan Proyek | PROJECT_OVERVIEW.html | `docs/PKL/` |
| Diagram Database | ERD.html | `docs/PKL/` |
| User Flows | USER_FLOW.html | `docs/PKL/` |
| Data Flows | DATABASE_FLOW.html | `docs/PKL/` |
| Referensi Teknis | TECHNICAL_DOCS.md | `docs/PKL/` |
| Setup Cepat | QUICK_START.md | `docs/guides/` |
| Setup Lengkap | SETUP_GUIDE.md | `docs/guides/` |
| Struktur Folder | FOLDER_STRUCTURE.md | Root |
| Folder Visual | FOLDER_OVERVIEW.html | `docs/` |

---

## 🚀 Setup Development

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Setup database
bash scripts/setup-database.sh

# 4. Run development server
php artisan serve
# Akses: http://localhost:8000
```

---

## 📁 Struktur Project

```
umkm-sales/
├── docs/PKL/              ← 🎯 PRESENTASI PKL
│   ├── INDEX.html         → Start here!
│   ├── PROJECT_OVERVIEW.html
│   ├── ERD.html
│   ├── USER_FLOW.html
│   ├── DATABASE_FLOW.html
│   ├── TECHNICAL_DOCS.md
│   └── README.md
│
├── docs/guides/           ← Setup guides
│   ├── QUICK_START.md
│   ├── SETUP_GUIDE.md
│   └── ...
│
├── app/                   ← Source code
├── database/              ← Migrations & seeders
├── routes/                ← Web routes
├── resources/             ← Views & assets
├── public/                ← Web root
└── scripts/               ← Automation
```

---

## ✅ Checklist Presentasi

- [ ] Download/copy semua files di `docs/PKL/`
- [ ] Test buka INDEX.html di browser
- [ ] Baca docs/PKL/README.md untuk urutan presentasi
- [ ] Screenshot docs untuk hardcopy backup
- [ ] Print atau PDF semua documentasi
- [ ] Test koneksi internet untuk demo live

---

## 🎤 Presentasi Flow

**Slide 1-2:** Buka `PROJECT_OVERVIEW.html`
- Ringkasan proyek
- Fitur-fitur
- Tech stack
- Checklist

**Slide 3-4:** Tampilkan `ERD.html`
- Database diagram
- Relasi tabel

**Slide 5-8:** Demo `USER_FLOW.html`
- Login/register
- Input transaksi
- Lihat laporan

**Slide 9+:** Referensi `DATABASE_FLOW.html`
- Detail teknis
- Query optimization

**Q&A:** Gunakan `TECHNICAL_DOCS.md`
- Jawab pertanyaan teknis
- Reference detail

---

## 📞 File Quick Reference

**"Berapa tabel database?"**
→ Lihat ERD.html

**"Gimana alur transaksinya?"**
→ Lihat DATABASE_FLOW.html

**"Apa saja fiturnya?"**
→ Lihat PROJECT_OVERVIEW.html

**"Bagaimana cara setup?"**
→ Lihat docs/guides/QUICK_START.md

**"Query gimana?"**
→ Lihat TECHNICAL_DOCS.md

---

## 🎉 Ready!

**Dokumentasi siap untuk presentasi PKL!**

👉 **Mulai dari:** `docs/PKL/INDEX.html`

Good luck! 🚀

---

*UMKM Sales System v1.0 | November 2026*
*Kelompok 4 - SMK AS-SYAFI'IYAH 01 JAKARTA*
