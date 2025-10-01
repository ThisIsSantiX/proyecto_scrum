FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpq-dev && \
    docker-php-ext-install pdo_mysql pdo_pgsql zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# CRÍTICO: Desactivar OPcache que causa el problema
RUN echo "opcache.enable=0" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.enable_cli=0" >> /usr/local/etc/php/conf.d/opcache.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

COPY . /var/www/html

RUN rm -rf bootstrap/cache/*.php \
    storage/framework/cache/* \
    storage/framework/views/* \
    storage/framework/sessions/*

RUN composer install --no-dev --no-scripts --optimize-autoloader --no-interaction

RUN composer dump-autoload --optimize --classmap-authoritative

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    mkdir -p /var/www/html/storage/framework/sessions \
            /var/www/html/storage/framework/views \
            /var/www/html/storage/framework/cache/data \
            /var/www/html/storage/logs && \
    chmod -R 775 /var/www/html/storage/framework && \
    chown -R www-data:www-data /var/www/html/storage

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 8080
ENV PORT=8080

RUN echo '#!/bin/bash\n\
set -e\n\
export PORT=${PORT:-8080}\n\
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf\n\
sed -i "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf\n\
php artisan migrate --force 2>&1 || true\n\
php artisan db:seed --force 2>&1 || true\n\
chown -R www-data:www-data /var/www/html/storage\n\
chmod -R 775 /var/www/html/storage\n\
exec apache2-foreground' > /start.sh && chmod +x /start.sh

CMD ["/start.sh"]