#!/bin/bash
echo "==================================="
echo "  UMKM Sales - Database Setup"
echo "==================================="
echo ""

# Check if MariaDB is installed
if ! command -v mysql &> /dev/null; then
    echo "📦 Installing MariaDB..."
    sudo apt update
    sudo apt install -y mariadb-server mariadb-client
else
    echo "✅ MariaDB already installed"
fi

# Start MariaDB
echo "🚀 Starting MariaDB service..."
sudo service mariadb start

# Wait a bit for service to start
sleep 2

# Setup database
echo "🔐 Creating database and user..."
sudo mysql -e "CREATE DATABASE IF NOT EXISTS umkm_sales CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'umkm_user'@'localhost' IDENTIFIED BY 'umkm_password';"
sudo mysql -e "GRANT ALL PRIVILEGES ON umkm_sales.* TO 'umkm_user'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

echo ""
echo "✅ Database setup completed!"
echo ""
echo "Database credentials:"
echo "  Database: umkm_sales"
echo "  Username: umkm_user"
echo "  Password: umkm_password"
echo "  Host: localhost"
echo ""
echo "Next steps:"
echo "  cd /home/samlong/umkm-sales"
echo "  php artisan migrate"
echo "  php artisan serve"
