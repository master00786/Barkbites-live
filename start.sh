#!/usr/bin/env bash
set -e

# Ensure storage/cache folders are writable
chmod -R 775 storage bootstrap/cache || true
chown -R www-data:www-data storage bootstrap/cache || true

# Generate APP_KEY if not set
if [ -z "${APP_KEY}" ] || [ "${APP_KEY}" = "base64:" ]; then
  php artisan key:generate --force || true
fi

# Clear caches (safe)
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

# Run migrations (only if DB is reachable)
php artisan migrate --force || true

# Rebuild caches (optional)
php artisan config:cache || true
php artisan view:cache || true

# Start Apache
apache2-foreground
