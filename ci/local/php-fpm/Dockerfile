FROM php:7.4-fpm

ARG UID
ARG GID

USER root

COPY --chown=www-data:www-data ./usr /usr
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update
RUN apt-get install -y autoconf pkg-config libssl-dev
RUN pecl install mongodb-1.7.0
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

RUN apt-get update && \
    apt-get install -y \
            libzip-dev \
            zip \
            libpq-dev \
            libfreetype6-dev \
            libmcrypt-dev \
            libicu-dev\
    && apt-get install -y libxml2-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-install soap \
    && docker-php-ext-install pcntl

RUN usermod -u $UID www-data \
    && groupmod -g $GID www-data \
    && rm /var/log/lastlog \
    && rm /var/log/faillog

WORKDIR /app

USER www-data