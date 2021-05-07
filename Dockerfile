FROM fjortegan/dwes:laravel
ADD ./ShareVolume/* /var/www/html
RUN chown -R www-data:www-data /var/www/html/*
RUN chown -R www-data:www-data /var/www/html/.*
