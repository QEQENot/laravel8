FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libfreetype6-dev libjpeg62-turbo-dev \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath fileinfo gd \
    && apt-get clean

RUN echo "display_errors=On\nerror_reporting=E_ALL\nlog_errors=On" > /usr/local/etc/php/conf.d/errors.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 777 storage bootstrap/cache

EXPOSE 8000

CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
