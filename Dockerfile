FROM php:8.3-apache
RUN apt-get update && apt-get install -y \
    git \
    vim \
    nano \
    curl \
    links \
    telnet
RUN docker-php-ext-install mysqli pdo pdo_mysql
WORKDIR /var/www/html
COPY . .
