FROM dunglas/frankenphp:php8.2-bookworm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mbstring zip xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Directorio de trabajo
WORKDIR /app

# Copiar archivos
COPY . .

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN php artisan key:generate || true
RUN php artisan storage:link || true

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
