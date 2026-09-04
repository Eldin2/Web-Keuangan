FROM php:8.2-fpm

# Install system dependencies, PostgreSQL client & PHP extensions
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nginx libpq-dev

# Install pdo_mysql AND pdo_pgsql
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Gunakan port dinamis dari environment variable PORT bawaan Render (default 10000 jika kosong)
ENV PORT=10000

CMD php artisan config:clear && php artisan serve --host=0.0.0.0 --port=$PORT
