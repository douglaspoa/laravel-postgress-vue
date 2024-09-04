FROM php:8.3-fpm

# Set your user name, ex: user=carlos
ARG user=dodos
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copiar os arquivos do projeto para o container
COPY . /var/www

# Instalar dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Ajustar permissões de diretórios necessários
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expor a porta 8000
EXPOSE 8000

# Comando para iniciar o servidor Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
