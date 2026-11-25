#!/bin/bash
# Setup script untuk UMKM Sales Project

echo "📦 Installing MariaDB..."
sudo apt install -y mariadb-server mariadb-client

echo "🚀 Starting MariaDB..."
sudo service mariadb start

echo "🔐 Setup database..."
sudo mysql -e "CREATE DATABASE IF NOT EXISTS umkm_sales;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'umkm_user'@'localhost' IDENTIFIED BY 'umkm_password';"
sudo mysql -e "GRANT ALL PRIVILEGES ON umkm_sales.* TO 'umkm_user'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

echo "✅ Database setup completed!"
echo ""
echo "Database Name: umkm_sales"
echo "Username: umkm_user"
echo "Password: umkm_password"
