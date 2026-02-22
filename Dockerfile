FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

COPY .env.example .env
RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/html/storage

RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite
COPY .env.example .env
RUN sed -i 's/SESSION_DRIVER=database/SESSION_DRIVER=cookie/' .env
RUN sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
RUN php artisan key:generate