# Imagen base
FROM php:8.1-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpq-dev && \
    docker-php-ext-install pdo_mysql pdo_pgsql zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de la app
COPY . /var/www/html

# Limpiar caches temporales de Laravel
RUN rm -rf bootstrap/cache/*.php \
    storage/framework/cache/* \
    storage/framework/views/* \
    storage/framework/sessions/*

# Instalar dependencias de PHP (solo producción)
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN composer dump-autoload --optimize

# Permisos de storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    mkdir -p /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/storage/framework/cache/data \
             /var/www/html/storage/logs && \
    chmod -R 775 /var/www/html/storage/framework

# Configurar DocumentRoot y AllowOverride
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Puerto
EXPOSE 8080
ENV PORT=8080

# CMD final
CMD bash -c "\
    sed -i 's/Listen 80/Listen ${PORT:-8080}/' /etc/apache2/ports.conf && \
    sed -i 's/:80>/:${PORT:-8080}>/' /etc/apache2/sites-available/000-default.conf && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan migrate --force 2>&1 && \   
    php artisan db:seed --force 2>&1 || true && \
    chown -R www-data:www-data /var/www/html/storage && \
    chmod -R 775 /var/www/html/storage && \
    apache2-foreground"
