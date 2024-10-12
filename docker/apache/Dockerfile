FROM php:8.3-apache

WORKDIR /var/www/html

# Install unzip utility and libs needed by zip PHP extension 
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip

RUN apt-get install -y libzip-dev zip && docker-php-ext-install zip 

EXPOSE 80