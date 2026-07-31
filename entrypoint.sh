#!/bin/bash
set -e

PORT="${PORT:-10000}"

# Build nginx listen directives: platform PORT + 8080 (Railway) + 10000 (Render), deduped
LISTEN_BLOCK="listen ${PORT} default_server;"
if [ "${PORT}" != "8080" ]; then
  LISTEN_BLOCK="${LISTEN_BLOCK}\n    listen 8080;"
fi
if [ "${PORT}" != "10000" ]; then
  LISTEN_BLOCK="${LISTEN_BLOCK}\n    listen 10000;"
fi

echo "=== PORT=${PORT} ==="
echo "=== nginx listen directives ==="
echo -e "${LISTEN_BLOCK}"

sed -i "s|__LISTEN__|${LISTEN_BLOCK}|" /etc/nginx/sites-enabled/default

echo "=== nginx config check ==="
nginx -t

php artisan migrate --force 2>&1 || true
php artisan db:seed --force 2>&1 || true
php artisan storage:link --force 2>&1 || true

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
