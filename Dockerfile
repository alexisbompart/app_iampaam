FROM php:8.2-apache

# Instalar extensiones y herramientas necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_pgsql zip

# Instalar Node.js 18.x y npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Habilitar mod_rewrite (para Laravel)
RUN a2enmod rewrite

# Copiar configuración personalizada de PHP (si tienes php.ini)
# COPY php.ini /usr/local/etc/php/

# Instalar dependencias de PHP (Composer) y Node
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
