# Use official PHP image with Apache
FROM php:8.2-apache

# Enable mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Install required dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy all source files
COPY . .

# Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create .env file from example
RUN cp .env.example .env

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set document root to Laravel public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Generate Laravel app key
RUN php artisan key:generate

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80
