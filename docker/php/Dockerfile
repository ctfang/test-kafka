FROM php:7.2-fpm

RUN apt-get update \
    && apt-get install -y librdkafka-dev git zip unzip wget \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

ADD / /app

WORKDIR app