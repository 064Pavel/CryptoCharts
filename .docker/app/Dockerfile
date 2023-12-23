# Используем официальный образ PHP 8.0 FPM
FROM php:8.0-fpm

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем расширения PHP для работы с MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Копируем кастомный php.ini
COPY ./.docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Устанавливаем пакеты, необходимые для установки Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Опционально можно установить другие зависимости, если они нужны для вашего проекта

# Ваш код и инструкции по запуску приложения

# Помечаем порт 9000, который используется PHP-FPM
EXPOSE 9000

# Команда запуска PHP-FPM
CMD ["php-fpm"]