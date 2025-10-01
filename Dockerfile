# Imagen base PHP 8.2 + Apache
FROM php:8.2-apache

# Instalar dependencias necesarias y extensiones de PHP
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpq-dev && \
    docker-php-ext-install pdo_mysql pdo_pgsql zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Activar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar Composer desde imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de Laravel
COPY . /var/www/html

# CRÍTICO: Eliminar cualquier cache que venga del repo
RUN rm -rf bootstrap/cache/*.php \
    storage/framework/cache/data/* \
    storage/framework/views/*.php \
    storage/framework/sessions/*

# Instalar dependencias
RUN composer install --no-dev --no-scripts --optimize-autoloader --no-interaction

# Regenerar autoload COMPLETAMENTE
RUN composer dump-autoload --optimize --classmap-authoritative

# Dar permisos correctos y crear directorios de sesiones
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    mkdir -p /var/www/html/storage/framework/sessions \
            /var/www/html/storage/framework/views \
            /var/www/html/storage/framework/cache \
            /var/www/html/storage/logs && \
    chmod -R 775 /var/www/html/storage/framework && \
    chown -R www-data:www-data /var/www/html/storage

# Configurar Apache para DocumentRoot correcto
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer puerto
EXPOSE 8080
ENV PORT=8080

# Script de inicio MÍNIMO
RUN echo '#!/bin/bash\n\
set -e\n\
export PORT=${PORT:-8080}\n\
\n\
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf\n\
sed -i "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf\n\
\n\
php artisan migrate --force 2>&1 || true\n\
php artisan db:seed --force 2>&1 || true\n\
\n\
chown -R www-data:www-data /var/www/html/storage\n\
chmod -R 775 /var/www/html/storage\n\
\n\
exec apache2-foreground' > /start.sh && chmod +x /start.sh

CMD ["/start.sh"]