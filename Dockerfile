FROM php:8.3-apache-bookworm

RUN apt-get update && apt-get install -y git curl wget nano zip unzip libpng-dev libonig-dev libxml2-dev zlib1g-dev \
    libssl-dev npm
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd opcache

RUN pecl install protobuf grpc
RUN docker-php-ext-enable protobuf grpc

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN npm install --save-dev vite laravel-vite-plugin
RUN npn run build

# run migrations before start
COPY ./scripts/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

CMD ["apache2-foreground"]