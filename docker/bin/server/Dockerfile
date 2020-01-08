FROM php:7.1.20-apache

RUN apt-get -y update --fix-missing
RUN apt-get upgrade -y

# Install useful tools
RUN apt-get -y install vim wget

# Install important libraries
RUN apt-get -y install --fix-missing git curl libcurl3 libcurl3-dev

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Other PHP7 Extensions
RUN docker-php-ext-install curl
RUN docker-php-ext-install json

RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_vars = 5000;" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 256M;" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 256M;" >> /usr/local/etc/php/conf.d/uploads.ini

# Enable apache modules
RUN a2enmod rewrite headers ssl

RUN ln -s /usr/local/bin/php /usr/bin/php

COPY default.conf /etc/apache2/sites-enabled/000-default.conf

# xdebug
ARG WITH_XDEBUG=false

RUN if [ $WITH_XDEBUG = "true" ] ; then \
        pecl install xdebug; \
        docker-php-ext-enable xdebug; \
        echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi ;

RUN apt-get autoremove -y
RUN apt-get clean

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer.phar
