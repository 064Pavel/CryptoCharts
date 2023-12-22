FROM php:8.1-fpm

RUN apt-get update \
  && apt-get install -y libzip-dev zip \
  && docker-php-ext-install zip pdo_mysql \
  && rm -rf /var/lib/apt/lists/*

COPY ./.docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN composer install

EXPOSE 80


