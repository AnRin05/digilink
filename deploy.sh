#!/bin/bash

echo "Starting Laravel deployment..."

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache

# Clear and cache routes
php artisan route:cache

# Clear and cache views
php artisan view:cache

# Optimize the application
php artisan optimize

echo "Deployment completed successfully!"