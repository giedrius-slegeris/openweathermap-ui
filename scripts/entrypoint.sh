#!/bin/sh
set -e

cd /app

php artisan db:create
php artisan migrate

exec apache2-foreground