#!/bin/bash

echo "Starting Laravel deployment..."

# Generate application key
php artisan key:generate

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run database migrations with force
php artisan migrate:refresh --force

# Cache everything for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize the application
php artisan optimize

echo "Deployment completed successfully!"