SHELL := /bin/bash

setup:
	@echo "Starting containers..."
	@docker compose up -d
	@echo "Waiting for MySQL to be ready..."
	@until docker compose exec mysql mysqladmin ping -h127.0.0.1 --silent; do \
		echo "Waiting..."; \
		sleep 2; \
	done
	@echo "Copying .env and generating app key..."
	@docker compose exec app cp -n .env.docker .env || true
	@echo "Installing PHP dependencies..."
	@docker compose exec app composer install
	@docker compose exec app php artisan key:generate
	@echo "Running migrations and seeders..."
	@docker compose exec app php artisan migrate --seed
	@echo "Setup complete."

up:
	@echo "Starting containers..."
	@docker compose up -d

down:
	@echo "Stopping services..."
	@docker compose down

fresh:
	@echo "Resetting database..."
	@docker compose exec app php artisan migrate:fresh --seed

remove:
	@echo "Removing containers, networks, volumes..."
	@docker compose down -v
