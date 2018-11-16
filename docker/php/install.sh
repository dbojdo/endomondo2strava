#!/bin/bash
apt-get update && apt-get install -y \
       libfreetype6-dev \
       libmcrypt-dev \
       libpng12-dev \
       libpq-dev \
       git \
       subversion \
   && docker-php-ext-install -j$(nproc) iconv mcrypt bcmath \
   && docker-php-ext-install -j$(nproc) zip \
   && pecl install apcu \
   && docker-php-ext-enable apcu \
   && pecl install xdebug \
   && docker-php-ext-enable xdebug
