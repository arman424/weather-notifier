# Laravel Project Makefile

.PHONY: setup build up down restart install key migrate seed optimize permissions env logs test

# Setup the entire project
setup: env build up install key migrate seed permissions optimize

# Build Docker containers
build:
	docker-compose build

# Start the containers
up:
	docker-compose up -d

# Stop the containers
down:
	docker-compose down

# Restart the containers
restart: down up

# Install PHP dependencies
install:
	docker exec php composer install

# Generate application key
key:
	docker exec php php artisan key:generate

# Run database migrations
migrate:
	docker exec php php artisan migrate --force

# Seed the database
seed:
	docker exec php php artisan db:seed --force

# Clear and cache configurations
optimize:
	docker exec php php artisan optimize

# Set proper permissions
permissions:
	sudo chmod -R 777 storage bootstrap/cache

# Copy .env file if missing
env:
	cp -n .env.example .env || true

# View logs
logs:
	docker-compose logs -f

# Run Laravel tests
test:
	docker exec php php artisan test
