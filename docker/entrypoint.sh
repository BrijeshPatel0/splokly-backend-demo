#!/bin/sh
set -e

if [ "$stage" = "development" ]; then
  composer install
  chmod -R 777 /var/www/html/storage
fi

echo "Run Migrations"
cd /var/www/html && php artisan migrate

echo "Run defined command in CMD Dockerfile"
exec "$@"
