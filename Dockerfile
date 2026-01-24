FROM node:22-alpine AS node-builder
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build


# -------------------------------
# 2️⃣ Laravel PHP
# -------------------------------
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libzip-dev libpq-dev libpng-dev \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Сначала зависимости Composer (быстрее кешируется)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Копируем весь проект
COPY . .

# ✅ Копируем Vite build внутрь public/build
COPY --from=node-builder /app/public/build /var/www/public/build

# Права
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["php-fpm"]

