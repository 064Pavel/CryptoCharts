FROM php:8.2-fpm

# Установка необходимых пакетов
RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-utils \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    zip \
    unzip \
    git && \
    docker-php-ext-install pdo_pgsql && \
    docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd zip && \
    docker-php-ext-install bcmath pdo_mysql && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Копирование конфигурационного файла php.ini
COPY ./.docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Установка Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Установка рабочей директории
WORKDIR /var/www

# Копирование приложения и установка зависимостей Composer
COPY . /var/www
RUN composer install --prefer-dist --no-progress --no-suggest --no-interaction

# Проверка версии Composer
RUN composer -v
