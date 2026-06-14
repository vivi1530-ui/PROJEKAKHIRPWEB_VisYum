FROM php:8.2-apache

# 1. Install dependensi sistem dan ekstensi PHP pdo_mysql untuk database
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql bcmath

# 2. Aktifkan mod_rewrite Apache agar routing url web Laravel tidak 404
RUN a2enmod rewrite

# 3. Ubah arah folder Apache langsung ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Tentukan lokasi kerja dan salin semua codingan dari laptop
WORKDIR /var/www/html
COPY . .

# 5. Pasang Composer dan unduh folder vendor (tanpa memicu script otomatis)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-scripts --optimize-autoloader

# 6. Atur hak akses folder agar session dan keranjang belanja bisa ditulis
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# 7. Jalankan Apache murni (ini anti-intercept dan anti-command-cancelled)
CMD ["apache2-foreground"]