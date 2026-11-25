# 🚀 QUICK START GUIDE - UMKM Sales

## 📋 Persyaratan Minimum

✅ PHP 8.2+ (Anda punya: PHP 8.4 ✓)
✅ Composer 2.0+
✅ MariaDB/MySQL 10.x+
✅ Git (opsional)

## ⚡ Setup Cepat (5 Menit)

### 1. Install Dependencies

```bash
cd /home/samlong/umkm-sales
composer install
```

### 2. Setup Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Setup Database

**Otomatis:**
```bash
chmod +x setup-db.sh
sudo ./setup-db.sh
```

**Manual:**
```bash
# Start MariaDB
sudo service mariadb start

# Create database
sudo mysql << EOF
CREATE DATABASE IF NOT EXISTS umkm_sales;
CREATE USER IF NOT EXISTS 'umkm_user'@'localhost' IDENTIFIED BY 'umkm_password';
GRANT ALL PRIVILEGES ON umkm_sales.* TO 'umkm_user'@'localhost';
FLUSH PRIVILEGES;
