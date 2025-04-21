FROM php:8.1-apache

# Instalar utilidades, Composer y extensiones de PHP
RUN apt-get update \
    && apt-get install -y git unzip curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copiar configuración de PHP
COPY php.ini /usr/local/etc/php/conf.d/php.ini

# Directorio de trabajo (document root)
WORKDIR /var/www/html

# Cambiar el DocumentRoot de Apache a public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri "s|DocumentRoot /var/www/html|DocumentRoot ${APACHE_DOCUMENT_ROOT}|g" /etc/apache2/sites-available/*.conf \
    && sed -ri "s|<Directory /var/www/html>|<Directory ${APACHE_DOCUMENT_ROOT}>|g" /etc/apache2/apache2.conf \
    # Permitir .htaccess en public/
    && sed -ri "s|AllowOverride None|AllowOverride All|g" /etc/apache2/apache2.conf