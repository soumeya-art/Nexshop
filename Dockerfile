FROM php:8.4-cli

# Dépendances système
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip libpq-dev

# Extensions PHP (IMPORTANT : PostgreSQL)
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Installer Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Lancement propre
CMD php artisan optimize:clear && php artisan migrate --force && php artisan db:seed --class=NexshopDemoSeeder && php artisan serve --host=0.0.0.0 --port=10000
