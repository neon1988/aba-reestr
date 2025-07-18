FROM dunglas/frankenphp

# Установка зависимостей
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    libzip-dev libcurl4-openssl-dev pkg-config libssl-dev libhiredis-dev libmagickwand-dev libpq-dev \
    libmemcached-dev zlib1g-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка стандартных расширений PHP
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl intl bcmath gd zip

# Установка PECL расширений
RUN pecl install imagick && docker-php-ext-enable imagick \
 && pecl install memcached && docker-php-ext-enable memcached \
 && pecl install redis && docker-php-ext-enable redis

# Установка Composer из официального образа
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY ./docker/php.ini /usr/local/lib/php.ini
COPY ./docker/php.ini /lib/php.ini
COPY ./docker/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php.ini /usr/local/etc/php/conf.d/php.ini

# Добавление healthcheck
COPY ./docker/healthcheck-horizon /usr/local/bin/healthcheck-horizon
RUN chmod +x /usr/local/bin/healthcheck-horizon

# Добавление пользователя с UID 1000 и GID 1000
ARG UID=1000
ARG GID=1000
RUN groupadd -g ${GID} appgroup && \
    useradd -u ${UID} -g ${GID} -ms /bin/bash user

# Настройка рабочего каталога
WORKDIR /var/www/html

# Копируем весь проект
COPY . .

# Создание директорий storage/framework и установка прав
RUN mkdir -p /var/www/html/storage/framework/cache/data && \
    mkdir -p /var/www/html/storage/framework/sessions  && \
    mkdir -p /var/www/html/storage/framework/views && \
    mkdir -p /var/www/html/storage/logs

# Установка зависимостей Laravel
RUN composer install --no-dev --prefer-dist --no-interaction

# Добавление директории в список безопасных для Git
RUN git config --global --add safe.directory /var/www/html

# Кэширование конфигурации и маршрутов
RUN php artisan optimize

# Очистка apt-кеша дополнительно после всех установок
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Указание порта для frankenphp
EXPOSE 8000

# Переход на пользователя user с UID 1000
USER user
