############################
# 1️⃣ Build frontend
############################
FROM node:20-alpine AS node-build

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY resources ./resources
COPY vite.config.* ./
RUN npm run build


############################
# 2️⃣ Backend PHP
############################
FROM dunglas/frankenphp:php8.2

# Instalar extensiones PHP necesarias
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

# Copiar assets compilados
COPY --from=node-build /app/public/build ./public/build

# Dependencias PHP
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
