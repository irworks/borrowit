# ----------------------
# Composer install step
# ----------------------
FROM composer:2.7 AS build

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
FROM node:20-alpine AS node

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
FROM php:8.3-fpm AS php_fpm

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN docker-php-ext-install -j$(nproc) pdo_mysql

WORKDIR /app

COPY ./deployment/php-www.conf /usr/local/etc/php-fpm.d/www.conf

# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

USER laravel

COPY --chown=laravel . /app
COPY --chown=laravel --from=build /app/vendor/ /app/vendor/
COPY --chown=laravel --from=node /app/public/build/manifest.json /app/public/build/manifest.json

RUN chmod -R 750 /app/storage

FROM nginx:mainline-alpine AS web_server

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel
RUN sed -i "s/user  nginx/user laravel/g" /etc/nginx/nginx.conf

WORKDIR /app/public

COPY ./deployment/nginx.conf.template /etc/nginx/templates/default.conf.template

COPY ./public/ /app/public/
COPY --from=node /app/public/build/ /app/public/build/
