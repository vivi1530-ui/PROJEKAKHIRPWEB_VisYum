FROM php:8.2-cli

# 1. Install dependensi Linux & ekstensi PHP wajib untuk database
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql bcmath

# 2. Tentukan lokasi kerja di dalam server
WORKDIR /var/www/html
COPY . .

# 3. Pasang Composer dan unduh folder vendor secara bersih
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-scripts --optimize-autoloader

# 4. Berikan hak akses folder storage dan cache
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 80

# 5. Nyalakan web server internal PHP langsung menembak ke port 80 dan folder public
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]