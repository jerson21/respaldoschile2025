FROM php:8.1-apache

# Instalar extensiones de MySQL y habilitar rewrite
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

# Copiar configuración de PHP
COPY php.ini /usr/local/etc/php/conf.d/php.ini

# Directorio de trabajo (document root)
WORKDIR /var/www/html