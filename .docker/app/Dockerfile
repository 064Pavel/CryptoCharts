FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      libjpeg-dev \
      zip unzip \
      git && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-configure gd --with-jpeg && \
      docker-php-ext-install -j$(nproc) gd zip && \
      docker-php-ext-install bcmath && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./.docker/app/php.ini /usr/local/etc/php/conf.d/php.ini
COPY composer.*  ./

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

RUN composer install \
      --no-interaction \
      --no-plugins \
      --no-suggest \
      --no-scripts \
      --no-autoloader \
      --prefer-dist

WORKDIR /var/www
