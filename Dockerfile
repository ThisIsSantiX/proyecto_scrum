# Imagen base con PHP 8.2 + Apache
FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl && \
    docker-php-ext-install pdo_mysql zip

# Configuración de Apache (activar mod_rewrite)
RUN a2enmod rewrite

# Copiar los archivos de Laravel al contenedor
COPY . /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer (copiado desde la imagen oficial de Composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 👇 Permitir composer como root y correr instalación
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Dar permisos a storage y bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Exponer el puerto
EXPOSE 80

# 👇 Al arrancar el contenedor:
# 1. Ejecuta migraciones con --force
# 2. Cachea config y rutas
# 3. Arranca Apache
CMD php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    apache2-foreground
