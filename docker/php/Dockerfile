FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    default-mysql-client \
    zlib1g-dev \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
  && docker-php-ext-install \
    pdo_mysql \
    zip \
    intl \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www
