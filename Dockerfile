FROM php:8.2-apache

# 1. Install system dependencies & PHP extensions wajib
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql bcmath

# 2. Aktifkan mod_rewrite Apache agar routing web Laravel tidak Error 404
RUN a2enmod rewrite

# 3. Ubah Document Root Apache agar langsung mengarah ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Tentukan working directory dan salin kodinganmu
WORKDIR /var/www/html
COPY . .

# 5. Pasang Composer terbaru dan install dependensi vendor
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 6. Atur hak akses folder storage agar bisa menulis log session/keranjang belanja
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80