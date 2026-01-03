FROM php:8.3-fpm

# Устанавливаем пакеты
RUN apt update && apt install -y \
    nano \
    bash \
    zip unzip git curl \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql

# Устанавливаем Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем файлы зависимостей
COPY composer.json composer.lock ./

# Ставим зависимости БЕЗ dev и scripts
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts

# Копируем весь проект
COPY . .

# Выполняем package:discover (если artisan есть)
RUN php artisan package:discover --ansi || true

# Права
RUN chown -R www-data:www-data /var/www

USER www-data
