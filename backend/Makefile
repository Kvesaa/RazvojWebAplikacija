# Aviation Management API - Development Scripts

.PHONY: help install test docs migrate seed fresh-setup serve

# Default target
help:
	@echo "Available commands:"
	@echo "  install      - Install PHP dependencies"
	@echo "  test         - Run PHPUnit tests"
	@echo "  docs         - Generate API documentation with Scribe"
	@echo "  migrate      - Run database migrations"
	@echo "  seed          - Run database seeders"
	@echo "  fresh-setup   - Fresh database setup with migrations and seeding"
	@echo "  serve         - Start Laravel development server"
	@echo "  setup         - Complete project setup"

# Install dependencies
install:
	composer install

# Run tests
test:
	php artisan test

# Generate API documentation
docs:
	php artisan scribe:generate

# Run migrations
migrate:
	php artisan migrate

# Run seeders
seed:
	php artisan db:seed

# Fresh database setup
fresh-setup:
	php artisan migrate:fresh --seed

# Start development server
serve:
	php artisan serve

# Complete project setup
setup: install fresh-setup docs
	@echo "Project setup complete!"
	@echo "Run 'make serve' to start the development server"
	@echo "API documentation will be available at http://localhost:8000/docs"




