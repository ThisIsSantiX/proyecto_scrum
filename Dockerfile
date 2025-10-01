# Imagen base PHP 8.2 + Apache
FROM php:8.2-apache

# Instalar dependencias necesarias y extensiones de PHP
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpq-dev && \
    docker-php-ext-install pdo_mysql pdo_pgsql zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Activar mod_rewrite de Apache
RUN a2enmod rewrite

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de Laravel
COPY . /var/www/html

# Instalar Composer desde imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Dar permisos correctos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configurar Apache para DocumentRoot correcto y eliminar warnings
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer puerto por defecto
EXPOSE 8080
ENV PORT=8080

# Script inline de inicio - CORREGIDO
RUN echo '#!/bin/bash\n\
set -e\n\
export PORT=${PORT:-8080}\n\
echo "Starting on port $PORT"\n\
\n\
# Configurar Apache para el puerto dinámico\n\
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf\n\
sed -i "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf\n\
\n\
# Iniciar Apache en background primero\n\
apache2ctl start\n\
echo "Apache started on port $PORT"\n\
\n\
# Ahora ejecutar comandos de Laravel (no bloquean)\n\
php artisan config:clear\n\
php artisan cache:clear\n\
echo "Testing database connection..."\n\
php artisan migrate --force || echo "ERROR: Migration failed - check database credentials"\n\
php artisan db:seed --force || echo "WARNING: Seeding failed"\n\
php artisan config:cache\n\
# php artisan route:cache  # Comentado por conflicto de rutas\n\
\n\
# Mantener Apache en foreground\n\
apache2ctl -D FOREGROUND' > /start.sh && chmod +x /start.sh

CMD ["/start.sh"]