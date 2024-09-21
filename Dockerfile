FROM php:8.3-apache-bookworm

RUN apt-get update && apt-get install -y git curl wget

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash -E
RUN apt install symfony-cli

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

CMD ["tail", "-f", "/dev/null"]