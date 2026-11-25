# 🔧 PHP COMPATIBILITY GUIDE

## Versi PHP yang Didukung

✅ **PHP 8.2+** (Recommended)  
✅ **PHP 8.3**  
✅ **PHP 8.4**  

## Current Configuration

### composer.json
```json
"require": {
    "php": "^8.2",
    "laravel/framework": "^11.0",
    "laravel/sanctum": "^4.0",
    "laravel/tinker": "^2.9"
}
```

**Penjelasan:**
- `"php": "^8.2"` - Artinya PHP 8.2.0 atau lebih tinggi
- Kompatibel dengan: PHP 8.2.x, 8.3.x, 8.4.x
- **TIDAK** kompatibel dengan: PHP 8.1 atau lebih rendah

## Laravel 11 Requirements

Laravel 11 membutuhkan:
- ✅ PHP 8.2 minimum
- ✅ BCMath PHP Extension
- ✅ Ctype PHP Extension
- ✅ cURL PHP Extension
- ✅ DOM PHP Extension
- ✅ Fileinfo PHP Extension
- ✅ JSON PHP Extension
- ✅ Mbstring PHP Extension
- ✅ OpenSSL PHP Extension
- ✅ PCRE PHP Extension
- ✅ PDO PHP Extension
- ✅ Tokenizer PHP Extension
- ✅ XML PHP Extension

## Verifikasi PHP Extensions

```bash
# Cek versi PHP
php -v

# Cek extensions yang terinstall
php -m

# Cek extension spesifik
php -m | grep -i pdo
php -m | grep -i mbstring
php -m | grep -i curl
```

## Installation di Berbagai Environment

### Ubuntu/Debian (PHP 8.2)

```bash
# Add repository
sudo add-apt-repository ppa:ondrej/php
sudo apt update

# Install PHP 8.2
sudo apt install php8.2 php8.2-cli php8.2-common php8.2-mysql \
    php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl \
    php8.2-xml php8.2-bcmath
```

### Ubuntu/Debian (PHP 8.3)

```bash
# Install PHP 8.3
sudo apt install php8.3 php8.3-cli php8.3-common php8.3-mysql \
    php8.3-zip php8.3-gd php8.3-mbstring php8.3-curl \
    php8.3-xml php8.3-bcmath
```

### Windows (XAMPP/WAMP)

1. Download XAMPP dengan PHP 8.2+ dari https://www.apachefriends.org/
2. Install dan jalankan Apache + MySQL
3. Pastikan PHP extensions aktif di `php.ini`:
   ```ini
   extension=curl
   extension=fileinfo
   extension=mbstring
   extension=mysqli
   extension=openssl
   extension=pdo_mysql
   ```

### WSL (Windows Subsystem for Linux)

```bash
# Update package list
sudo apt update

# Install PHP 8.2
sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-cli \
    php8.2-common php8.2-mbstring php8.2-xml php8.2-curl \
    php8.2-zip php8.2-gd php8.2-bcmath
```

## Troubleshooting

### Issue: "php: command not found"

**Solution:**
```bash
# Cek apakah PHP terinstall
which php

# Jika tidak ada, install
sudo apt install php8.2-cli
```

### Issue: "Your requirements could not be resolved"

**Solution:**
```bash
# Clear cache
composer clear-cache

# Update composer
composer self-update

# Install dengan ignore platform reqs (untuk development)
composer install --ignore-platform-reqs
```

### Issue: Extension not found

**Solution:**
```bash
# Install missing extensions (contoh: mbstring)
sudo apt install php8.2-mbstring

# Restart web server
sudo service apache2 restart
# atau
sudo service php8.2-fpm restart
```

## Version Switching (Multiple PHP Versions)

Jika Anda punya multiple PHP versions:

```bash
# Cek versi aktif
php -v

# Switch ke PHP 8.2
sudo update-alternatives --set php /usr/bin/php8.2

# Switch ke PHP 8.3
sudo update-alternatives --set php /usr/bin/php8.3

# Untuk Apache
sudo a2dismod php8.3
sudo a2enmod php8.2
sudo service apache2 restart
```

## Testing Compatibility

### 1. Cek PHP Version
```bash
php -v
```

Expected output:
```
PHP 8.2.x atau lebih tinggi
```

### 2. Cek Laravel Version
```bash
php artisan --version
```

Expected output:
```
Laravel Framework 11.x.x
```

### 3. Cek Composer
```bash
composer diagnose
```

### 4. Run Application
```bash
php artisan serve
```

Jika tidak ada error, aplikasi **KOMPATIBEL** ✅

## Production Deployment

### Nginx dengan PHP-FPM 8.2

```nginx
server {
    listen 80;
    server_name umkmsales.com;
    root /var/www/umkm-sales/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Apache dengan PHP 8.2

```apache
<VirtualHost *:80>
    ServerName umkmsales.com
    DocumentRoot /var/www/umkm-sales/public

    <Directory /var/www/umkm-sales/public>
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:unix:/var/run/php/php8.2-fpm.sock|fcgi://localhost"
    </FilesMatch>
</VirtualHost>
```

## Performance Optimization (PHP 8.2+)

### php.ini Optimization

```ini
; Memory
memory_limit = 256M

; Upload
upload_max_filesize = 20M
post_max_size = 20M

; Execution
max_execution_time = 60

; OPcache (Production)
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.validate_timestamps=0
opcache.save_comments=1
opcache.fast_shutdown=1
```

## Security Considerations

### Disable Dangerous Functions

```ini
disable_functions = exec,passthru,shell_exec,system,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source
```

### Hide PHP Version

```ini
expose_php = Off
```

## Upgrade Path

### From PHP 8.1 to PHP 8.2

1. Backup aplikasi dan database
2. Install PHP 8.2
3. Update composer.json: `"php": "^8.2"`
4. Run: `composer update`
5. Test aplikasi
6. Switch PHP version
7. Clear cache: `php artisan cache:clear`

### From PHP 8.2 to PHP 8.3

Laravel 11 sudah kompatibel dengan PHP 8.3:

```bash
# Install PHP 8.3
sudo apt install php8.3-cli php8.3-fpm php8.3-mysql ...

# Switch version
sudo update-alternatives --set php /usr/bin/php8.3

# Test
php artisan serve
```

## Compatibility Matrix

| PHP Version | Laravel 11 | UMKM Sales | Status |
|-------------|------------|------------|--------|
| 8.1.x       | ❌         | ❌         | Not supported |
| 8.2.x       | ✅         | ✅         | **Recommended** |
| 8.3.x       | ✅         | ✅         | Supported |
| 8.4.x       | ✅         | ✅         | Supported |

## Support & Help

Jika mengalami masalah kompatibilitas:

1. Cek versi PHP: `php -v`
2. Cek extensions: `php -m`
3. Validate composer: `composer validate`
4. Clear cache: `composer clear-cache`
5. Reinstall: `composer install`

## Summary

✅ **UMKM Sales sudah KOMPATIBEL dengan PHP 8.2+**
✅ Requirement minimum: PHP 8.2.0
✅ Tested dengan: PHP 8.2, 8.3, 8.4
✅ Laravel 11 fully supported
✅ All dependencies compatible

---

**Last Updated:** 24 September 2026  
**PHP Version Tested:** 8.2.x, 8.3.x, 8.4.x  
**Laravel Version:** 11.56.1  
**Status:** ✅ Production Ready
