FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN apt update
RUN apt install -y python

RUN apt-get update && apt-get install -y r-base
