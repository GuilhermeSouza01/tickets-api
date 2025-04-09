# Etapa 1: imagem base com PHP + extensões
FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do projeto
COPY . .

# Instala dependências Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissões para cache e storage
RUN chown -R www-data:www-data storage bootstrap/cache

# Porta usada no Laravel
EXPOSE 8000

# Comando para iniciar o Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
