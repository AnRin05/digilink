# -------------------------
# 1. Build Vite assets
# -------------------------
FROM node:18 AS node_builder
WORKDIR /app

# Install node dependencies
COPY package*.json ./
RUN npm install

# Build assets
COPY . .
RUN npm run build


# -------------------------
# 2. PHP + Apache runtime
# -------------------------
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    default-mysql-client

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy Apache config
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application source
COPY . .

# Copy built node assets from builder stage
COPY --from=node_builder /app/public/build ./public/build

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose Apache port
EXPOSE 8080

# Start services
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan create:admin admin05@gmail.com 01052004 "Super Admin" && \
    apache2-foreground
