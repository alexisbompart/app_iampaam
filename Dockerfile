FROM php:8.2-apache

# Instalar extensiones necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql

# Habilitar mod_rewrite de Apache (para Laravel)
RUN a2enmod rewrite

# Copiar configuración personalizada de PHP (opcional)
COPY php.ini /usr/local/etc/php/
