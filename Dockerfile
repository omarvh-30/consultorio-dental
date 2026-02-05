############################
# 1️⃣ Build frontend
############################
FROM node:20-alpine AS node-build

WORKDIR /app

COPY package*.json ./
RUN npm install

# 👇 COPIAMOS TODO PARA QUE TAILWIND VEA LAS VISTAS
COPY . .

RUN npm run build


############################
# 2️⃣ Laravel + FrankenPHP
############################
FROM dunglas/frankenphp:php8.2

RUN install-php-extensions \
    gd \
    mbstring \
    pdo_mysql \
    zip \
    xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

COPY Caddyfile /app/Caddyfile
COPY --from=node-build /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader

ENV APP_ENV=production
ENV APP_DEBUG=false

EXPOSE 8080
