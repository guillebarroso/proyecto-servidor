FROM fjortegan/dwes:laravel
COPY ./ShareVolume/ /var/www/html
RUN chown -R www-data:www-data /var/www/html/*
RUN chown -R www-data:www-data /var/www/html/.*

#docker exec -it pruebadocker_servidor_1 bin/bash
#
#php artisan migrate