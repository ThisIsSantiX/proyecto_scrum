# Imagen base PHP 8.2 + Apache
FROM php:8.2-apache

# Instalar dependencias necesarias y extensiones de PHP
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl && \
    docker-php-ext-install pdo_mysql zip && \
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

# Configurar Apache para DocumentRoot correcto
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' >> /etc/apache2/sites-available/000-default.conf

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
php artisan config:clear || true\n\
php artisan migrate --force 2>&1 || echo "Migration warning (check DB connection)"\n\
php artisan db:seed --force 2>&1 || echo "Seeding warning"\n\
\n\
# NO cachear rutas si hay conflictos\n\
php artisan config:cache || true\n\
# php artisan route:cache || true  # Comentado por conflicto de rutas\n\
\n\
# Mantener Apache en foreground\n\
apache2ctl -D FOREGROUND' > /start.sh && chmod +x /start.sh

CMD ["/start.sh"]