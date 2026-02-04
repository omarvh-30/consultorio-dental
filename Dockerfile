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
# 2️⃣ Backend PHP (FrankenPHP)
############################
FROM dunglas/frankenphp:php8.2

# Extensiones PHP necesarias
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

# Assets compilados
COPY --from=node-build /app/public/build ./public/build

# Dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# ⚠️ MUY IMPORTANTE
ENV APP_ENV=production
ENV APP_DEBUG=false

# FrankenPHP escucha automáticamente
EXPOSE 8080
