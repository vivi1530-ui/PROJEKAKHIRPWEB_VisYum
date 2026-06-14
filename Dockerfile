FROM php:8.2-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache nginx supervisor curl libpng-dev libxml2-dev zip unzip git \
    && docker-php-ext-install pdo_mysql bcmath

WORKDIR /var/www/html
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Jalankan server lewat script builtin
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]