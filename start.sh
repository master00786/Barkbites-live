#!/usr/bin/env bash
set -e

echo "=== Booting BarkBites on Render ==="

# 1) Permissions
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# 2) Laravel caches clear (safe)
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# 3) DB migrate (safe)
php artisan migrate --force || true

# 4) Cache again (optional)
php artisan config:cache || true
php artisan view:cache || true

# 5) Render PORT binding (CRITICAL)
if [ -z "${PORT}" ]; then
  echo "ERROR: PORT env not set by Render"
  exit 1
fi

echo "Binding Apache to PORT=${PORT}"

# Force Apache to listen on Render's PORT on all interfaces
cat > /etc/apache2/ports.conf <<EOF
Listen 0.0.0.0:${PORT}
EOF

# Ensure DocumentRoot = Laravel public + VirtualHost uses PORT
cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:${PORT}>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

# 6) Start Apache
echo "Starting Apache..."
exec apache2-foreground
