FROM php:7.4-fpm

ARG UID
ARG GID

USER root

COPY --chown=www-data:www-data ./usr /usr

RUN usermod -u $UID www-data \
    && groupmod -g $GID www-data \
    && rm /var/log/lastlog \
    && rm /var/log/faillog

USER www-data