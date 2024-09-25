FROM php:8.3-apache-bookworm

RUN apt-get update && apt-get install -y git curl wget nano libicu-dev zlib1g-dev libzip-dev unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure intl && docker-php-ext-install intl opcache zip \
    && pecl install apcu
RUN docker-php-ext-enable opcache apcu

COPY ./opcache/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./apcu/apcu.ini /usr/local/etc/php/conf.d/apcu.ini

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash -E
RUN apt install symfony-cli

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

CMD ["apache2ctl", "-D", "FOREGROUND"]