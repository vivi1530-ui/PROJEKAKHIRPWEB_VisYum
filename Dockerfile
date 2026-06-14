FROM php:8.2-apache

# 1. Install dependensi sistem & ekstensi PHP wajib
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql bcmath

# 2. Aktifkan mod_rewrite Apache agar routing url web Laravel tidak 404
RUN a2enmod rewrite

# 3. Ubah Document Root Apache langsung ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Amankan log Apache agar dialihkan ke stdout/stderr biar tidak bikin crash
RUN ln -sf /dev/stdout /var/log/apache2/access.log && ln -sf /dev/stderr /var/log/apache2/error.log

# 5. Tentukan lokasi kerja dan salin codingan
WORKDIR /var/www/html
COPY . .

# 6. Pasang Composer dan unduh vendor tanpa menjalankan script sensitif
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-scripts --optimize-autoloader

# 7. Berikan hak akses penuh ke folder storage & cache (wajib agar Apache tidak tertolak)
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]