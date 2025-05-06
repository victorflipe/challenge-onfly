FROM php:8.2-fpm

# Instala dependências
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria diretório da aplicação
WORKDIR /var/www

COPY . .

# Instala dependências PHP
RUN composer install

# Permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000

# CMD ["php-fpm"]
