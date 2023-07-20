# Образ системы где будет запускаться код
FROM php:7.3-fpm-alpine

RUN apk add --update --no-cache curl && curl -sS https://getcomposer.org/installer --output installer && php ./installer --version="2.2.5" && mv composer.phar /usr/local/bin/composer

RUN apk add --update --no-cache libzip-dev \
    curl-dev \
    icu-dev \
    libmcrypt-dev \
    libvpx-dev \
    libpng-dev \
    libpng-dev \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    libxpm-dev \
    libxml2-dev \
    unixodbc-dev \
    libpq-dev  \
    imagemagick \
    imagemagick-dev\
    && curl -Ls https://raw.githubusercontent.com/dagwieers/unoconv/master/unoconv -o /usr/local/bin/unoconv \
    && chmod +x /usr/local/bin/unoconv \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install mbstring pdo_mysql curl json intl gd xml zip bz2 opcache dom && docker-php-ext-configure gd \
  --with-gd \
  --with-jpeg-dir \
  --with-png-dir \
  --with-zlib-dir && pecl install redis && docker-php-ext-enable redis \
    && pecl install imagick && docker-php-ext-enable imagick

RUN echo "upload_max_filesize = 20M" >> /usr/local/etc/php/conf.d/local.ini \
    && echo "post_max_size = 20M" >> /usr/local/etc/php/conf.d/local.ini \
    && echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/local.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/local.ini \
    && echo "extension=imagick.so" >> /usr/local/etc/php/conf.d/local.ini