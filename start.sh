#!/usr/bin/env bash
set -e

# -----------------------------
# 1) Permissions (safe on Render)
# -----------------------------
chmod -R 775 storage bootstrap/cache || true
chown -R www-data:www-data storage bootstrap/cache || true

# -----------------------------------------
# 2) IMPORTANT: DO NOT run key:generate here
# APP_KEY Render Environment Variables me set hota hai.
# -----------------------------------------

# -----------------------------
# 3) Clear caches (safe)
# -----------------------------
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# -----------------------------
# 4) Run migrations (safe)
# -----------------------------
php artisan migrate --force || true

# -----------------------------
# 5) Rebuild caches (optional)
# -----------------------------
php artisan config:cache || true
php artisan view:cache || true

# -----------------------------
# 6) IMPORTANT: Bind Apache to Render's PORT
# -----------------------------
if [ -n "${PORT}" ]; then
  # Make Apache listen on Render-provided $PORT
  sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf || true

  # Update default vhost to use the same port
  sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf || true
fi

# -----------------------------
# 7) Start Apache
# -----------------------------
apache2-foreground
