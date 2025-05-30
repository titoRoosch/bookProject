FROM php:8.2-apache

# Instalar dependências do sistema e extensões PHP
RUN apt-get update \
    && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libpq-dev \
        zip \
        unzip \
        curl \
        git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        pdo \
        pdo_pgsql \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# Verifica versão do Composer
RUN composer --version

# Copia configuração do Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos da aplicação
COPY . .

# Ajusta permissões
RUN chown -R www-data:www-data storage bootstrap/cache

# Instala dependências PHP
RUN composer install || (cat composer.lock && exit 1)

# Exibe os arquivos da pasta vendor
RUN ls -la vendor

EXPOSE 80

CMD ["apache2-foreground"]
