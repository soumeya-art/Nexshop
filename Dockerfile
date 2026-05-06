# --------------------
# PHP + Composer stage
# --------------------
FROM php:8.4-cli AS php

RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader


# --------------------
# Node stage (BUILD assets)
# --------------------
FROM node:20 AS node

WORKDIR /app
COPY . .

RUN npm install
RUN npm run build
RUN ls -la public/build || echo "NO BUILD FOUND"

# --------------------
# Final stage (runtime)
# --------------------
FROM php:8.4-cli

WORKDIR /app

RUN apt-get update && apt-get install -y libpq-dev \
 && docker-php-ext-install pdo pdo_pgsql

COPY --from=php /app /app
COPY --from=node /app/public/build /app/public/build

EXPOSE 10000

sh -c "test -f public/build/manifest.json || npm install && npm run build; php artisan optimize:clear && php artisan serve --host 0.0.0.0 --port 10000"
