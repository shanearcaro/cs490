FROM php:8.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y

COPY --from=composer /usr/bin/composer /usr/bin/composer

CMD [ "composer", "test" ]