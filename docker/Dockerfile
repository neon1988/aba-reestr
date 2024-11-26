FROM php:8.3-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    libzip-dev libcurl4-openssl-dev pkg-config libssl-dev libmagickwand-dev libpq-dev

# Установка стандартных расширений PHP
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl intl bcmath gd zip

# Установка Imagick через PECL
RUN pecl install imagick && docker-php-ext-enable imagick

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Настройка рабочего каталога
WORKDIR /var/www/html

# Копирование файлов
COPY . .

# Установка зависимостей Laravel
RUN composer install --no-dev --optimize-autoloader

RUN php artisan octane:install --server=frankenphp

# Кэширование конфигурации и маршрутов
RUN php artisan optimize

# Указание порта для Swoole
EXPOSE 8000

# Команда для запуска Octane
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]
