FROM php:8.4.1-fpm-alpine3.19

# Install system dependencies
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libzip-dev \
    zlib-dev

RUN apk update
RUN apk upgrade
RUN apk add --no-cache ffmpeg
RUN apk add --no-cache python3

# Install yt-dlp
RUN wget -O /usr/local/bin/yt-dlp https://github.com/yt-dlp/yt-dlp/releases/latest/download/yt-dlp && \
    chmod +x /usr/local/bin/yt-dlp

# Install PHP extensions
RUN docker-php-ext-install gd \
    && docker-php-ext-install zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install node and npm
RUN apk add --no-cache nodejs npm
RUN chown -R 1000:1000 /var/www/*

RUN composer require --dev phpunit/phpunit
RUN composer install
RUN yt-dlp https://youtu.be/eI9-q863KTc?si=phh8snfjGtveaXvD --no-cache-dir

# Set working directory
WORKDIR /var/www

EXPOSE 9000