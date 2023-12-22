FROM php:8.2-fpm

# Замена зеркал Debian на официальные
RUN echo "deb http://deb.debian.org/debian buster main" > /etc/apt/sources.list && \
    echo "deb-src http://deb.debian.org/debian buster main" >> /etc/apt/sources.list && \
    echo "deb http://security.debian.org/debian-security buster/updates main" >> /etc/apt/sources.list && \
    echo "deb-src http://security.debian.org/debian-security buster/updates main" >> /etc/apt/sources.list

# Установка зависимостей и расширений PHP
RUN apt-get update \
    && apt-get install -y \
        apt-utils \
        libpq-dev \
        libpng-dev \
        libzip-dev \
        zip \
        unzip \
        git \
    && docker-php-ext-install pdo_mysql bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Копирование конфигурации PHP
COPY ./.docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Установка Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Рабочая директория
WORKDIR /var/www

# Копирование приложения и установка зависимостей Composer
COPY . /var/www
RUN composer install --prefer-dist --no-progress --no-suggest --no-interaction
