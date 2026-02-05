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

# 👇 Agregar Node
RUN apt-get update && apt-get install -y \
    nodejs \
    npm \
    chromium \
    ca-certificates \
    fonts-liberation \
    libatk-bridge2.0-0 \
    libgtk-3-0 \
    libx11-xcb1 \
    libxcomposite1 \
    libxdamage1 \
    libxrandr2 \
    libgbm1 \
    libnss3 \
    libasound2 \
    libxshmfence1 \
    libdrm2 \
    && rm -rf /var/lib/apt/lists/*

RUN npm install -g puppeteer    

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

COPY Caddyfile /app/Caddyfile
COPY --from=node-build /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader

ENV APP_ENV=production
ENV APP_DEBUG=false

EXPOSE 8080
