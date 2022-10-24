FROM php:8.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
RUN apt-get install python3 -y
RUN touch /var/www/html/src/middle/question.py
RUN chmod 777 /var/www/html/src/middle/question.py

COPY --from=composer /usr/bin/composer /usr/bin/composer

# CMD [ "composer", "test" ]