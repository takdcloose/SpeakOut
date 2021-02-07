FROM php:7-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libjpeg-dev \
        && docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo_mysql
