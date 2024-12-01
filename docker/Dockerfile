FROM dunglas/frankenphp

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    libzip-dev libcurl4-openssl-dev pkg-config libssl-dev libmagickwand-dev libpq-dev \
    libmemcached-dev zlib1g-dev

# Установка стандартных расширений PHP
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl intl bcmath gd zip

# Установка Imagick через PECL
RUN pecl install imagick && docker-php-ext-enable imagick

RUN pecl install memcached && docker-php-ext-enable memcached

RUN apt-get update && apt-get install -y \
    libssl-dev libhiredis-dev \
    && pecl install redis \
    && docker-php-ext-enable redis

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY ./php.ini /usr/local/lib/php.ini
COPY ./php.ini /lib/php.ini
COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

# Настройка рабочего каталога
WORKDIR /var/www/html

# Копирование файлов
COPY . .

# Добавление директории в список безопасных для Git
RUN git config --global --add safe.directory /var/www/html

# Установка зависимостей Laravel
RUN composer install --no-dev

#RUN php artisan octane:install --server=frankenphp

# Кэширование конфигурации и маршрутов
RUN php artisan optimize

# Указание порта для frankenphp
EXPOSE 8000
