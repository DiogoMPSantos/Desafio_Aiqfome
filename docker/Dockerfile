FROM php:8.3-fpm

# System deps
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
 && docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Workdir
WORKDIR /var/www/html

# Laravel permissions
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
