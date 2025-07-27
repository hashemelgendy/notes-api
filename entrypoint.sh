#!/bin/bash
set -e

echo "Composer version:"
composer --version || exit 1

if [ ! -f vendor/autoload.php ]; then
    echo "Running composer install..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ ! -f .env ]; then
    echo "Copying .env.docker to .env"
    cp .env.docker .env
fi

echo "Starting Laravel..."
exec php artisan serve --host=0.0.0.0 --port=8000
