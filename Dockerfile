FROM php:8.1-cli-alpine

WORKDIR /app

COPY . .

RUN apk update \
    && apk add -q unzip \
    && curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer \
    && chmod +x /usr/bin/composer \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

CMD [ "php", "-a" ]