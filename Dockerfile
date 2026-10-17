# Imagen para Coolify (EC2): PHP 8.3 + nginx (serversideup), escucha en 8080.
# storage/ y lang/vendor/ son volúmenes persistentes de Coolify: subidas,
# licencia de Botble, credenciales de Google y traducciones editadas en el panel.
FROM serversideup/php:8.3-fpm-nginx

USER root
RUN install-php-extensions gd intl bcmath exif soap

ENV PHP_MEMORY_LIMIT=256M \
    PHP_UPLOAD_MAX_FILE_SIZE=2M \
    PHP_POST_MAX_SIZE=8M \
    PHP_OPCACHE_ENABLE=1 \
    NGINX_CLIENT_MAX_BODY_SIZE=20M

COPY --chown=www-data:www-data . /var/www/html
USER www-data
# El merge plugin de Botble relanza `package:discover`, que arranca la app y
# busca la base de datos (no existe en el build). Laravel genera ese manifiesto
# en el primer arranque, así que basta con que el autoload haya quedado escrito.
RUN (composer install --no-dev --optimize-autoloader --no-interaction --no-scripts \
     || test -f vendor/composer/autoload_classmap.php) \
 && rm -f bootstrap/cache/packages.php bootstrap/cache/services.php \
 && ln -sfn ../storage/app/public public/storage
