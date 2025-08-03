# Use official PHP with Apache
FROM php:8.1-apache

# Arguments
ARG APP_ENV=production

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer (latest version)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Clear composer cache (fixes "extracting archive" issues)
RUN composer clear-cache

# Install dependencies safely
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --prefer-dist --no-interaction --no-progress

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Expose port 80
EXPOSE 80

# Default Apache start command
CMD ["apache2-foreground"]
