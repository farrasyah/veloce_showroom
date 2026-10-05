#!/bin/sh
set -e

PORT="${PORT:-80}"
sed -i "s/__PORT__/${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

php artisan config:clear

# Jalankan migration otomatis setiap kali container start.
# Aman diulang-ulang karena Laravel skip migration yang sudah pernah jalan.
php artisan migrate --force || echo "Migration gagal — cek env DB_* di dashboard hosting."

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
