#!/usr/bin/env bash
set -e

# -----------------------------
# 1) Permissions (safe on Render)
# -----------------------------
chmod -R 775 storage bootstrap/cache || true
chown -R www-data:www-data storage bootstrap/cache || true

# -----------------------------------------
# 2) IMPORTANT: DO NOT run key:generate here
# Render Free me .env file hoti nahi, aur key:generate .env ko write/read try karta hai.
# APP_KEY hamesha Render Environment Variables me set karo (Generate button se).
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
# 6) Start Apache
# -----------------------------
apache2-foreground
