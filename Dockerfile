FROM php:8.2-fpm

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_pgsql \
    pgsql \
    zip \
    gd \
    bcmath \
    intl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar working directory
WORKDIR /var/www/html/app_iampaam

# Cambiar ownership
RUN chown -R www-data:www-data /var/www/html/app_iampaam \
    && chmod -R 755 /var/www/html/app_iampaam/storage \
    && chmod -R 755 /var/www/html/app_iampaam/bootstrap/cache

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
