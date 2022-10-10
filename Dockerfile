FROM php:7.4-fpm
COPY . /usr/cs490
WORKDIR /usr/cs490
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
COPY --from=composer /usr/bin/composer /usr/bin/composer

CMD [ "composer", "test" ]