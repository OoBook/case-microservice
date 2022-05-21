FROM php:7.4-fpm-alpine

RUN apk --update add --virtual build-dependencies build-base openssl-dev autoconf \
     && pecl install mongodb \
     && docker-php-ext-enable mongodb
     
RUN docker-php-ext-install pdo pdo_mysql sockets 


RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .
RUN composer install
