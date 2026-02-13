#!/usr/bin/env bash
set -e

# -----------------------------
# 1) Permissions (safe on Render)
# -----------------------------
chmod -R 775 storage bootstrap/cache || true
chown -R www-data:www-data storage bootstrap/cache || true

# -----------------------------
# 2) Clear caches (safe)
# -----------------------------
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# -----------------------------
# 3) Run migrations (safe)
# -----------------------------
php artisan migrate --force || true

# -----------------------------
# 4) Rebuild caches (optional)
# -----------------------------
php artisan config:cache || true
php artisan view:cache || true

# -----------------------------
# 5) BIND APACHE TO RENDER PORT (CRITICAL FIX)
# -----------------------------
if [ -n "$PORT" ]; then
  echo "Binding Apache to PORT=$PORT"

  # Replace ANY Listen directive with Render PORT
  sed -i -E "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf || true

  # Replace VirtualHost port
  sed -i -E "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf || true
fi

# -----------------------------
# 6) Start Apache
# -----------------------------
apache2-foreground
