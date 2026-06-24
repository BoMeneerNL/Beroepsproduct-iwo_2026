FROM php:8.5-apache

RUN a2enmod rewrite

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html
