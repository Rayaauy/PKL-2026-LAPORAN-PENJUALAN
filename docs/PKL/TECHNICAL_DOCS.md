# DOKUMENTASI TEKNIS - UMKM Sales System

**Aplikasi Web Pencatatan Penjualan UMKM**  
*Kelompok 4 - SMK AS-SYAFI'IYAH 01 JAKARTA*

---

## 📋 Daftar Isi

1. [Overview Sistem](#overview-sistem)
2. [Arsitektur Aplikasi](#arsitektur-aplikasi)
3. [Database Schema](#database-schema)
4. [Alur Fungsional](#alur-fungsional)
5. [Fitur Utama](#fitur-utama)
6. [Stack Teknologi](#stack-teknologi)
7. [Setup & Installation](#setup--installation)

---

## Overview Sistem

### Tujuan Aplikasi
Aplikasi web untuk membantu pemilik UMKM mencatat dan melacak penjualan produk secara digital, termasuk manajemen inventaris, kategori produk, dan laporan penjualan.

### Target User
- **Pemilik UMKM**: Input penjualan, lihat laporan, kelola stok
- **Admin/Moderator**: Manage blog & konten publik

### Fitur Utama
✓ Autentikasi & Autorisasi (Login/Register)  
✓ Manajemen Profil Bisnis  
✓ CRUD Kategori Produk  
✓ CRUD Produk dengan Stok  
✓ Input Transaksi Penjualan  
✓ Laporan & Export Data  
✓ Blog Publik  
✓ Admin Panel  

---

## Arsitektur Aplikasi

### MVC Architecture
```
UMKM-SALES/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── BusinessProfileController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── ProductController.php
│   │   │   ├── TransactionController.php
│   │   │   ├── ReportController.php
│   │   │   └── Admin/BlogController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── BusinessProfile.php
│   │   ├── Category.php
│   │   ├── Product.php
│   │   ├── Transaction.php
│   │   ├── TransactionItem.php
│   │   └── BlogPost.php
│   └── ...
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_create_users_table.php
│   │   ├── 2024_01_02_create_business_profiles_table.php
│   │   ├── 2024_01_03_create_categories_table.php
│   │   ├── 2024_01_04_create_products_table.php
│   │   ├── 2024_01_05_create_transactions_table.php
│   │   └── 2024_01_06_create_transaction_items_table.php
│   └── seeders/
├── routes/
│   ├── web.php (Web routes)
│   └── console.php
├── resources/
│   ├── views/ (Blade templates)
│   └── css/
├── public/
│   └── index.php (Entry point)
└── ...
```

### Alur Request-Response
```
Browser
   ↓
routes/web.php (Route matching)
   ↓
Controller (Business logic)
   ↓
Model (Database query)
   ↓
Database (Data storage)
   ↓
Response → View (Blade template)
   ↓
Browser (HTML rendered)
```

---

## Database Schema

### 1. Users Table
**Tujuan**: Menyimpan data pengguna

```sql
CREATE TABLE users (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  is_admin BOOLEAN DEFAULT FALSE,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

**Kolom Penting**:
- `id`: Kunci utama, auto-increment
- `email`: Unik, untuk login
- `is_admin`: Flag untuk admin/moderator
- `password`: Hashed (bcrypt)

**Relasi**:
- 1 user memiliki 1 business profile
- 1 user memiliki banyak kategori
- 1 user memiliki banyak produk
- 1 user memiliki banyak transaksi

---

### 2. BusinessProfiles Table
**Tujuan**: Data detail bisnis UMKM

```sql
CREATE TABLE business_profiles (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNSIGNED NOT NULL UNIQUE,
  business_name VARCHAR(255) NOT NULL,
  owner_name VARCHAR(255) NULL,
  address TEXT NULL,
  phone VARCHAR(15) NULL,
  description TEXT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Relasi**: Many-to-One (Belongs to User)

---

### 3. Categories Table
**Tujuan**: Kategori produk

```sql
CREATE TABLE categories (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNSIGNED NOT NULL,
  name VARCHAR(255) NOT NULL,
  description TEXT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Relasi**:
- Many-to-One: User
- One-to-Many: Products

---

### 4. Products Table
**Tujuan**: Data produk UMKM

```sql
CREATE TABLE products (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNSIGNED NOT NULL,
  category_id BIGINT UNSIGNED NULL,
  name VARCHAR(255) NOT NULL,
  description TEXT NULL,
  price DECIMAL(15,2) NOT NULL,
  stock INT DEFAULT 0,
  unit VARCHAR(50) DEFAULT 'pcs',
  is_active BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);
```

**Relasi**:
- Many-to-One: User
- Many-to-One: Category (nullable)
- One-to-Many: TransactionItems

**Catatan**: `stock` bersifat informatif (tidak otomatis decrement saat transaksi)

---

### 5. Transactions Table
**Tujuan**: Pencatatan penjualan

```sql
CREATE TABLE transactions (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNSIGNED NOT NULL,
  transaction_code VARCHAR(255) UNIQUE NOT NULL,
  transaction_date DATE NOT NULL,
  total_amount DECIMAL(15,2) DEFAULT 0,
  notes TEXT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Relasi**:
- Many-to-One: User
- One-to-Many: TransactionItems

**Format transaction_code**: `TRX-YYYYMMDD-XXXXX` (contoh: `TRX-20240105-00001`)

---

### 6. TransactionItems Table
**Tujuan**: Detail item dalam satu transaksi

```sql
CREATE TABLE transaction_items (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  transaction_id BIGINT UNSIGNED NOT NULL,
  product_id BIGINT UNSIGNED NOT NULL,
  product_name VARCHAR(255) NOT NULL,
  price DECIMAL(15,2) NOT NULL,
  quantity INT NOT NULL,
  subtotal DECIMAL(15,2) NOT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);
```

**Relasi**:
- Many-to-One: Transaction
- Many-to-One: Product

**Kolom Penting**:
- `product_name`: Snapshot nama saat transaksi (jika nanti nama produk berubah, history tetap akurat)
- `subtotal = quantity × price`

---

### 7. BlogPosts Table
**Tujuan**: Blog publik

```sql
CREATE TABLE blog_posts (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) UNIQUE NOT NULL,
  content LONGTEXT NOT NULL,
  published_at TIMESTAMP NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

**Catatan**: Hanya admin yang bisa buat/edit. Publik bisa baca jika `published_at` tidak NULL.

---

## Alur Fungsional

### 1️⃣ Alur Register & Login

```
┌─ User mengakses /register
├─ Input: name, email, password
├─ Validasi email unik
├─ Hash password (bcrypt)
├─ Simpan ke users table
└─ Redirect ke login page

┌─ User akses /login
├─ Input: email, password
├─ Query users table
├─ Verify password dengan hash
├─ Create session/token
└─ Redirect ke dashboard
```

### 2️⃣ Alur Setup Profil Bisnis

```
┌─ First time login
├─ Redirect ke /business/edit (jika belum ada profil)
├─ Input: business_name, owner_name, address, phone
├─ Validasi data
├─ Insert ke business_profiles table
└─ Redirect ke dashboard
```

### 3️⃣ Alur Kelola Kategori

```
INDEX /categories
  └─ Query categories WHERE user_id = auth_user_id
  
CREATE /categories
  ├─ Form: name, description
  ├─ Insert ke categories table
  └─ Redirect index dengan flash message
  
EDIT /categories/{id}
  ├─ Query kategori by ID
  ├─ Check ownership (user_id match)
  ├─ Update ke database
  └─ Redirect index
  
DELETE /categories/{id}
  ├─ Check ownership
  ├─ Check jika kategori ada di products (jika ada, soft delete atau error)
  ├─ Delete dari database
  └─ Redirect index
```

### 4️⃣ Alur Kelola Produk

```
INDEX /products
  └─ Query products WHERE user_id = auth_user_id
     Include category name via JOIN
  
CREATE /products
  ├─ Form: category_id, name, price, stock, unit, is_active
  ├─ Validasi price & stock (numeric)
  ├─ Insert ke products table
  └─ Redirect index
  
EDIT /products/{id}
  ├─ Check ownership
  ├─ Update name, price, stock, category_id, dll
  └─ Redirect index
  
DELETE /products/{id}
  ├─ Check ownership
  ├─ Check jika produk ada di transaction_items
  │  (Jika ada → soft delete atau error?)
  ├─ Delete dari database
  └─ Redirect index
```

### 5️⃣ Alur Input Transaksi

```
INDEX /transactions
  └─ Query transactions WHERE user_id + eager load items
  
CREATE /transactions
  ├─ Form Step 1: Pilih tanggal, catatan
  ├─ Form Step 2: Tambah item (loop)
  │  ├─ Select produk dari dropdown (user punya)
  │  ├─ Input quantity
  │  ├─ Price auto-fill dari products table
  │  └─ Subtotal = qty × price (client-side calc)
  ├─ Generate transaction_code unik
  ├─ Insert transaction + transaction_items (2 query atau transaction DB)
  ├─ total_amount = SUM(subtotal) semua items
  └─ Redirect index
  
SHOW /transactions/{id}
  ├─ Query transaction + items (JOIN)
  └─ Display detail penjualan
```

### 6️⃣ Alur Laporan & Export

```
GET /reports
  ├─ Hitung: total revenue, item count, unique products sold
  ├─ Buat chart data (Laravel Chart)
  └─ Display dashboard report
  
GET /reports/export
  ├─ Query transactions + items
  ├─ Convert ke CSV
  ├─ Download file (transactions.csv)
  └─ Client save ke lokal
```

---

## Fitur Utama

### 🔐 Authentication & Authorization

| Fitur | Public | User | Admin |
|-------|--------|------|-------|
| Lihat Homepage | ✓ | ✓ | ✓ |
| Baca Blog | ✓ | ✓ | ✓ |
| Login/Register | ✓ | - | - |
| Dashboard | - | ✓ | ✓ |
| Kategori (CRUD) | - | ✓ | - |
| Produk (CRUD) | - | ✓ | - |
| Transaksi (CR) | - | ✓ | - |
| Laporan | - | ✓ | - |
| Blog Admin | - | - | ✓ |

### Middleware
- `guest`: Untuk login/register form (redirect ke dashboard jika sudah login)
- `auth`: Untuk route yang butuh autentikasi
- `admin`: Untuk route admin only (check is_admin flag)
- `login.limiter`: Rate limit login attempts
- `throttle:60,1`: Rate limit 60 req/menit

---

## Stack Teknologi

### Backend
- **Laravel 11**: PHP framework
- **PHP 8.2+**: Language
- **MySQL/MariaDB**: Database
- **Laravel Sanctum**: API authentication (future)

### Frontend
- **Blade Templates**: Server-side rendering
- **HTML5 + CSS3**: Markup & styling
- **JavaScript**: Interactivity
- **Vite**: Asset bundler

### Tools & Libraries
- **Composer**: PHP dependency manager
- **NPM**: Node package manager
- **Git**: Version control
- **PHPUnit**: Testing (included)

### Environment
- **WSL/Ubuntu**: Development OS
- **PHP Built-in Server**: Testing
- **Apache/Nginx**: Production (optional)

---

## Setup & Installation

### Prerequisite
- PHP 8.2+ dengan extensions: mysql, pdo, json, ctype, fileinfo
- MySQL/MariaDB running
- Composer installed
- Node.js & NPM installed

### Step 1: Clone/Copy Project

```bash
cd ~/organized/projects/umkm-sales
```

### Step 2: Install Dependencies

```bash
# PHP dependencies
composer install

# Node dependencies
npm install
```

### Step 3: Setup Environment

```bash
# Copy .env.example
cp .env.example .env

# Generate app key
php artisan key:generate
```

### Step 4: Database Setup

```bash
# Create database migration
php artisan migrate

# (Optional) Seed dummy data
php artisan db:seed
```

### Step 5: Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### Step 6: Run Server

```bash
# Using Laravel built-in server
php artisan serve

# Default: http://127.0.0.1:8000
```

### Step 7: Test
- Buka http://localhost:8000
- Register akun baru
- Test CRUD features

---

## Model Relationships

### User Model
```php
$user->businessProfile()    // 1:1
$user->categories()         // 1:N
$user->products()           // 1:N
$user->transactions()       // 1:N
```

### BusinessProfile Model
```php
$profile->user()            // 1:1 inverse
```

### Category Model
```php
$category->user()           // 1:N inverse
$category->products()       // 1:N
```

### Product Model
```php
$product->user()            // 1:N inverse
$product->category()        // 1:N inverse
$product->transactionItems() // 1:N
```

### Transaction Model
```php
$transaction->user()        // 1:N inverse
$transaction->items()       // 1:N (TransactionItem)
```

### TransactionItem Model
```php
$item->transaction()        // 1:N inverse
$item->product()            // 1:N inverse
```

---

## Query Examples

### Get user products dengan kategori
```php
$products = Product::where('user_id', auth()->id())
                    ->with('category')
                    ->get();
```

### Get transaksi dengan items
```php
$transactions = Transaction::where('user_id', auth()->id())
                            ->with('items.product')
                            ->latest()
                            ->get();
```

### Total revenue user
```php
$total = Transaction::where('user_id', auth()->id())
                     ->sum('total_amount');
```

### Produk terlaris
```php
$topProducts = TransactionItem::selectRaw('product_id, product_name, SUM(quantity) as total_qty')
                                ->whereIn('transaction_id', 
                                    Transaction::where('user_id', auth()->id())->pluck('id'))
                                ->groupBy('product_id', 'product_name')
                                ->orderByDesc('total_qty')
                                ->limit(10)
                                ->get();
```

---

## Validasi Data

### Register
- name: required, string, max:255
- email: required, email, unique:users
- password: required, min:8, confirmed

### Login
- email: required, email
- password: required

### Product
- name: required, string, max:255
- price: required, numeric, min:0
- stock: integer, min:0
- category_id: exists:categories,id (nullable)

### Transaction
- transaction_date: required, date
- items: required, array, min:1
- items.*.product_id: required, exists:products,id
- items.*.quantity: required, integer, min:1

---

## Error Handling

### HTTP Response Codes
- **200**: Success
- **301/302**: Redirect
- **400**: Bad request
- **401**: Unauthorized
- **403**: Forbidden
- **404**: Not found
- **422**: Validation error
- **500**: Server error

### Exception Handling
- `ModelNotFoundException`: Jika resource tidak ditemukan → 404
- `AuthorizationException`: User tidak punya akses → 403
- `ValidationException`: Input tidak valid → 422 + error messages

---

## Security Notes

✓ Password hashed dengan bcrypt  
✓ CSRF protection via token  
✓ SQL injection protection via ORM  
✓ Rate limiting pada login & register  
✓ User ownership validation pada setiap resource  
✓ Authorization middleware check  

---

## Performance Optimization

- Eager loading relationships (with clause)
- Indexed foreign keys di database
- Caching untuk dashboard stats (optional)
- Pagination untuk list view (optional)

---

## Deployment Checklist

- [ ] Update .env untuk production
- [ ] Set APP_DEBUG=false
- [ ] Set APP_ENV=production
- [ ] Generate cache files: `php artisan optimize`
- [ ] Setup HTTPS/SSL
- [ ] Configure web server (Apache/Nginx)
- [ ] Setup database backup
- [ ] Monitor logs

---

**Dokumentasi ini dibuat untuk presentasi PKL Kelompok 4.**  
*Last updated: November 2026*