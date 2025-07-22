#!/bin/bash

echo "Resetting database..."
docker compose exec app php artisan migrate:fresh --seed
