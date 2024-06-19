# ----------------------
# Composer install step
# ----------------------
FROM composer:2.6 as build

WORKDIR /app

COPY composer.json composer.lock ./
COPY database/ database/

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# ----------------------
# npm install step
# ----------------------
FROM node:20-alpine as node

WORKDIR /app

COPY ./package.json ./package-lock.json /app/
COPY ./vite.config.js /app/
COPY resources /app/resources

RUN mkdir -p /app/public
RUN npm ci
RUN npm run build

# ----------------------
# The FPM production container
# ----------------------
FROM php:8.3-fpm as php_fpm

RUN docker-php-ext-install -j$(nproc) pdo_mysql

WORKDIR /app

COPY ./deployment/php-www.conf /usr/local/etc/php-fpm.d/www.conf

USER www-data

COPY --chown=www-data . /app
COPY --chown=www-data --from=build /app/vendor/ /app/vendor/
COPY --chown=www-data --from=node /app/public/build/manifest.json /app/public/build/manifest.json

RUN chmod -R 750 /app/storage

FROM nginx:mainline-alpine as web_server

WORKDIR /app/public

COPY ./deployment/nginx.conf.template /etc/nginx/templates/default.conf.template

COPY ./public/ /app/public/
COPY --from=node /app/public/build/ /app/public/build/
