# PHP stage
FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader


# Node stage
FROM node:20

WORKDIR /app
COPY . .

RUN npm install
RUN npm run build


# Final stage
FROM php:8.4-cli

WORKDIR /app

COPY --from=0 /app /app
COPY --from=1 /app/public/build /app/public/build

RUN apt-get update && apt-get install -y libpq-dev \
 && docker-php-ext-install pdo pdo_pgsql

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
