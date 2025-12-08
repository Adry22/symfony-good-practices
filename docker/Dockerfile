FROM php:8.2-fpm-buster

# Set up sources.list for debian buster archive
RUN echo "deb http://archive.debian.org/debian/ buster main" > /etc/apt/sources.list \
    && echo "deb http://archive.debian.org/debian-security/ buster/updates main" >> /etc/apt/sources.list \
    && echo "deb http://archive.debian.org/debian/ buster-updates main" >> /etc/apt/sources.list

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip vim nano libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# NODE CONFIGURATION
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt install nodejs

COPY php.ini /usr/local/etc/php

WORKDIR /var/www/symfony-good-practices

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony