# Образ проекта с исходным кодом
FROM docker.io/sirvellen/sirvellen:myfd

WORKDIR /var/www

RUN addgroup -S www && adduser -S www -G www
USER www

EXPOSE 9000
CMD ["php-fpm"]

COPY . /var/www
COPY --chown=www:www . /var/www
