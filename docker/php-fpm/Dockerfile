FROM php:8.1-fpm
WORKDIR "/app"

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip

RUN docker-php-ext-configure curl --with-curl=/usr/local/lib
RUN docker-php-ext-install curl pdo pdo_mysql mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
