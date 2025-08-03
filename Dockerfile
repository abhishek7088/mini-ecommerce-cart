# Use official PHP image with Apache
FROM php:8.2-apache

# Enable mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Install dependencies for Laravel
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Set working directory in the container
WORKDIR /var/www/html

# Copy Laravel app
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate app key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Set Apache doc root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Suppress Apache server name warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80