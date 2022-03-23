FROM php:5.6-apache
LABEL MAINTAINER="Pablo Sanches <sanches.webmaster@gmail.com>"

WORKDIR /app

ENV TZ=America/Sao_Paulo
ENV APACHE_LOG_DIR=/var/www/html/logs/apache/
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data

# Update sources
RUN apt-get update -y

# Enable "mod_rewrite" – http://httpd.apache.org/docs/current/mod/mod_rewrite.html
RUN a2enmod rewrite

# Enable "mod_headers" – http://httpd.apache.org/docs/current/mod/mod_headers.html
RUN a2enmod headers

# Enable "mod_expires" – http://httpd.apache.org/docs/current/mod/mod_expires.html
RUN a2enmod expires

# Enable ssl
RUN a2enmod ssl
#RUN a2enmod socache_shmcb

# Install "Git" – https://git-scm.com/
RUN apt-get install -y git

# Install "Composer" – https://getcomposer.org/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install WGET
RUN apt-get install -y wget curl

# Install Midnight Commander, Vim, Nano
RUN apt-get install -y mc vim nano

# Install GD Lib
RUN apt-get install -y libpng-dev zlib1g-dev

RUN docker-php-ext-install gd