FROM php:7.3-fpm

RUN apt-get update && \
    apt-get install -y systemd cron apt-utils automake libtool apt-transport-https wget iputils-ping mc mlocate zip unzip bzip2 gcc rpm subversion git gnupg autoconf

ADD crontab /etc/cron.d/cron

RUN chmod 0644 /etc/cron.d/cron

RUN touch /var/log/cron.log

# Instal PHP Extensions
RUN apt-get install -y libicu-dev libldap2-dev libjpeg62-turbo-dev libpng-dev libfreetype6-dev libxml2-dev libzip-dev && \
    docker-php-ext-install pdo pdo_mysql intl && \
    printf "\n" | pecl install apcu && \
    docker-php-ext-enable apcu && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap && \
    docker-php-ext-install -j$(nproc) iconv && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install opcache && \
    docker-php-ext-install zip && \
    docker-php-ext-install soap && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install exif && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    docker-php-ext-install pcntl