#!/bin/sh
set -e

echo "========================================="
echo "  SPK E-Wallet - Container Startup"
echo "========================================="

# ─── Wait for MySQL to be ready ───────────────────────────────────────────────
echo "[1/6] Waiting for database connection..."
until php artisan db:show --no-interaction > /dev/null 2>&1; do
    echo "  → Database not ready yet, retrying in 3s..."
    sleep 3
done
echo "  ✓ Database is ready"

# ─── Run migrations ───────────────────────────────────────────────────────────
echo "[2/6] Running migrations..."
php artisan migrate --force --no-interaction
echo "  ✓ Migrations done"

# ─── Seed data awal (idempotent - sudah ada guard if(!exists()) di seeder) ────
echo "[2b] Seeding initial data..."
php artisan db:seed --class=AdminSeeder --force --no-interaction
php artisan db:seed --class=DataAwalSeeder --force --no-interaction
echo "  ✓ Seeding done"

# ─── Create storage symlink ───────────────────────────────────────────────────
echo "[3/6] Creating storage symlink..."
php artisan storage:link --force 2>/dev/null || true
echo "  ✓ Storage symlink ready"

# ─── Cache optimization ───────────────────────────────────────────────────────
echo "[4/6] Optimizing caches..."
php artisan package:discover --ansi
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "  ✓ Caches warmed up"

# ─── Fix permissions ──────────────────────────────────────────────────────────
echo "[5/6] Fixing permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
echo "  ✓ Permissions set"

# ─── Start Supervisor ─────────────────────────────────────────────────────────
echo "[6/6] Starting services (Nginx + PHP-FPM + Queue)..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
