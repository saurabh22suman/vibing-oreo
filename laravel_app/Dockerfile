FROM php:8.2-fpm

# system deps
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    default-mysql-client \
  && docker-php-ext-configure gd --with-jpeg --with-freetype \
  && docker-php-ext-install pdo pdo_mysql zip gd mbstring xml

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# copy app
COPY . /var/www/html

# install php deps
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# set permissions for storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
# copy entrypoint and make executable
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh || true

EXPOSE 8000
CMD ["/usr/local/bin/entrypoint.sh"]
