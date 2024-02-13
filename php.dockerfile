FROM php:8.0-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd 
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install gd
