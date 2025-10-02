FROM php:8.4-fpm-alpine

# Dependências do sistema
RUN apk add --no-cache \
    bash git curl icu-dev oniguruma-dev libzip-dev zlib-dev \
    libpng-dev libjpeg-turbo-dev libxml2-dev autoconf g++ make mysql-client

# Extensões PHP
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) pdo_mysql mbstring zip bcmath intl gd pcntl opcache
RUN pecl install redis && docker-php-ext-enable redis

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Usuário e diretório
RUN addgroup -g 1000 app && adduser -D -G app -u 1000 app
WORKDIR /var/www

# (Opcional) instalar deps no build:
# COPY --chown=app:app composer.json composer.lock* ./
# RUN composer install --no-interaction --prefer-dist --no-scripts --no-progress || true

# Código e configs PHP
COPY --chown=app:app . .
COPY --chown=app:app docker/app/php.ini /usr/local/etc/php/php.ini
COPY --chown=app:app docker/app/local.ini /usr/local/etc/php/conf.d/local.ini

COPY --chown=app:app docker/app/entrypoint.sh /entrypoint.sh
USER root
RUN chmod +x /entrypoint.sh
USER app

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
EXPOSE 9000
HEALTHCHECK --interval=30s --timeout=5s --retries=3 CMD php -v || exit 1

