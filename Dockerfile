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

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Regenerar autoload después de copiar archivos
RUN composer dump-autoload --optimize

# Dar permisos correctos y crear directorios de sesiones
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    mkdir -p /var/www/html/storage/framework/sessions \
            /var/www/html/storage/framework/views \
            /var/www/html/storage/framework/cache \
            /var/www/html/storage/logs && \
    chmod -R 775 /var/www/html/storage/framework && \
    chown -R www-data:www-data /var/www/html/storage

# Configurar Apache para DocumentRoot correcto y eliminar warnings
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer puerto por defecto
EXPOSE 8080
ENV PORT=8080

# Script de inicio optimizado - ORDEN CORRECTO
RUN echo '#!/bin/bash\n\
set -e\n\
export PORT=${PORT:-8080}\n\
echo "Starting Laravel application on port $PORT"\n\
\n\
# Configurar Apache para el puerto dinámico\n\
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf\n\
sed -i "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf\n\
\n\
echo "Configuring Laravel..."\n\
\n\
# PASO 1: Limpiar TODO el cache PRIMERO\n\
php artisan optimize:clear || true\n\
php artisan config:clear || true\n\
php artisan cache:clear || true\n\
php artisan view:clear || true\n\
php artisan route:clear || true\n\
\n\
# PASO 2: Regenerar autoload de Composer\n\
echo "Regenerating autoload..."\n\
composer dump-autoload --optimize\n\
\n\
# PASO 3: Ejecutar migraciones y seeders\n\
echo "Running migrations..."\n\
php artisan migrate --force || echo "WARNING: Migrations failed"\n\
\n\
echo "Running seeders..."\n\
php artisan db:seed --force || echo "WARNING: Seeders failed"\n\
\n\
# PASO 4: AHORA SÍ cachear (después de regenerar autoload)\n\
echo "Caching configuration..."\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
# Asegurar permisos finales\n\
chown -R www-data:www-data /var/www/html/storage\n\
chmod -R 775 /var/www/html/storage\n\
\n\
echo "✓ Laravel configured successfully"\n\
echo "Starting Apache on port $PORT..."\n\
\n\
# Iniciar Apache en foreground\n\
exec apache2-foreground' > /start.sh && chmod +x /start.sh

CMD ["/start.sh"]