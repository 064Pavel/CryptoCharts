# Используйте официальный образ PHP 8.1 FPM
FROM php:8.1-fpm

# Копирование кастомного php.ini файла
COPY ./.docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Установка необходимых зависимостей
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Рабочая директория для приложения
WORKDIR /var/www

# Копирование зависимостей проекта (если уже есть composer.json и composer.lock)
COPY composer.json composer.lock /var/www/

# Установка зависимостей
RUN composer install --no-scripts --no-autoloader

# Копирование остальных файлов проекта
COPY . .

# Запуск Composer с автозагрузкой после копирования файлов
RUN composer dump-autoload --optimize
