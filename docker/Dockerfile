FROM php:8.1-alpine

RUN apk update

WORKDIR /var/www

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
RUN mkdir -p vendor/bin
ENV PATH /var/www/vendor/bin:${PATH}