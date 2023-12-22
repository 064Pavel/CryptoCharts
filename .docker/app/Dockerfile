# Используем официальный образ PHP 8.1 FPM
FROM php:8.1-fpm

# Устанавливаем необходимые расширения
RUN docker-php-ext-install pdo_mysql

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копируем пользовательский php.ini
COPY ./.docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Опционально можно добавить другие настройки и инструкции по установке зависимостей

