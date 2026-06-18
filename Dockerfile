# --- STAGE 1: Asset Compilation (Node) ---
FROM node:20-alpine AS node-builder
WORKDIR /app

# Copy package files and install dependencies
COPY package*.json ./
RUN npm install

# Copy all files and build assets with Vite
COPY . .
RUN npm run build

# --- STAGE 2: PHP Dependency Installation (Composer) ---
FROM php:8.4-fpm-alpine AS php-builder
WORKDIR /var/www

# 1. Install system dependencies
RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    sqlite-dev \
    linux-headers

# 2. Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_sqlite \
    gd \
    zip \
    intl \
    bcmath \
    opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files and install PHP dependencies
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction

# --- STAGE 3: Final Runtime Image ---
FROM php:8.4-fpm-alpine
WORKDIR /var/www

# Install only the runtime libraries needed (smaller image)
RUN apk add --no-cache \
    libpng \
    libzip \
    icu-libs \
    bash

# 1. Copy PHP extensions from php-builder
COPY --from=php-builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=php-builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# 2. Copy the entire Laravel app from php-builder
COPY --from=php-builder /var/www /var/www

# 3. Copy the compiled Vite assets from node-builder
# This places the manifest and minified files into public/build
COPY --from=node-builder /app/public/build /var/www/public/build

# Set correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose the port for Artisan Serve
EXPOSE 8000 5173

# Start the Laravel development server
# --host=0.0.0.0 is MANDATORY for Docker access
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]