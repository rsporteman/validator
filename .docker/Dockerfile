FROM php:8.1.5-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y git

# Install PHP extensions
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer