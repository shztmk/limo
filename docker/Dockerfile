FROM php:8.1-alpine

# see: https://stackoverflow.com/a/57650040
RUN apk update \
    && apk add icu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

WORKDIR /var/www

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
RUN mkdir -p vendor/bin
ENV PATH /var/www/vendor/bin:${PATH}