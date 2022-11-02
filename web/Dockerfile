FROM php:8.0-apache
RUN apt update && apt install -y libaprutil1-dbd-mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN a2enmod authn_dbd
