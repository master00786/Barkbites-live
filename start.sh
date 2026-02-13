#!/usr/bin/env bash
set -e

echo "Starting container…"

# -----------------------------
# 1) Permissions (Render safe)
# -----------------------------
chmod -R 775 storage bootstrap/cache || true
chown -R www-data:www-data storage bootstrap/cache || true

# -----------------------------
# 2) Clear Laravel caches
# -----------------------------
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# -----------------------------
# 3) Run migrations
# -----------------------------
php artisan migrate --force || true

# -----------------------------
# 4) Rebuild caches
# -----------------------------
php artisan config:cache || true
php artisan view:cache || true

# -----------------------------
# 5) FORCE Apache to bind Render PORT
# THIS IS THE MOST IMPORTANT PART
# -----------------------------
if [ -z "$PORT" ]; then
  echo "ERROR: PORT is not set by Render"
  exit 1
fi

echo "Binding Apache to 0.0.0.0:$PORT"

# Force Apache to listen on Render port
cat > /etc/apache2/ports.conf <<EOF
Listen 0.0.0.0:${PORT}
EOF

# Force VirtualHost to same port
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

# -----------------------------
# 6) Start Apache (foreground)
# -----------------------------
echo "Starting Apache…"
exec apache2-foreground
