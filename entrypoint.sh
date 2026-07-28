#!/bin/bash
set -e

# Substitute dynamic port into nginx config
sed -i "s/__PORT__/${PORT:-10000}/g" /etc/nginx/sites-enabled/default

php artisan migrate --force 2>&1 || true
php artisan db:seed --force 2>&1 || true
php artisan storage:link --force 2>&1 || true

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
