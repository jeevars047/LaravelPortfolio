FROM php:8.2-apache
WORKDIR /var/www/html
COPY . .
RUN chown -R www-data:www-data /var/www/html
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf