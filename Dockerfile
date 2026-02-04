FROM dunglas/frankenphp:php8.2

# Instalar extensiones PHP correctamente (forma recomendada)
RUN install-php-extensions \
    gd \
    mbstring \
    pdo_mysql \
    zip \
    xml

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Assets frontend
RUN npm install && npm run build

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
