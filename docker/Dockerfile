FROM php:8.1-apache AS base

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    netcat-traditional \
    && docker-php-ext-install zip pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

WORKDIR /var/www/html
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

#Dockerfile for development
FROM base AS development-stage

ENV stage=development

WORKDIR /var/www/html

ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]

#Dockerfile for production
FROM base AS production-stage

ENV stage=production

COPY . /var/www/html

#Composer for main app
WORKDIR /var/www/html
RUN composer install
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 755 /var/www/html/storage

WORKDIR /var/www/html
ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]
