# Образ проекта с исходным кодом
FROM registry.gitlab.com/kostylworks/bookaboom-api/php-fpm:5

WORKDIR /var/www

RUN addgroup -S www && adduser -S www -G www
USER www

EXPOSE 9000
CMD ["php-fpm"]

COPY . /var/www
COPY --chown=www:www . /var/www
