FROM php:7.3-fpm

RUN apt-get update && \
    apt-get install -y systemd cron apt-utils automake libtool apt-transport-https wget iputils-ping mc mlocate zip unzip bzip2 gcc rpm subversion git gnupg autoconf

# Cron && Supervisor
RUN touch /var/log/cron.log
RUN touch /var/log/queue.log
RUN touch /var/log/supervisord.log

RUN apt-get install -y supervisor

RUN touch /var/run/supervisor.sock && chmod 777 /var/run/supervisor.sock && service supervisor restart

COPY supervisor/supervisord.conf /etc/supervisor/supervisord.conf

RUN apt-get install -y cron
COPY supervisor/cron.d/schedule /etc/cron.d
RUN chmod -R 644 /etc/cron.d
RUN crontab /etc/cron.d/schedule

# Instal PHP Extensions
RUN apt-get install -y libicu-dev libldap2-dev libjpeg62-turbo-dev libpng-dev libfreetype6-dev libxml2-dev libzip-dev && \
    docker-php-ext-install pdo pdo_mysql intl && \
    printf "\n" | pecl install apcu && \
    docker-php-ext-enable apcu && \
    docker-php-ext-install opcache && \
    docker-php-ext-install zip && \
    docker-php-ext-install soap && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install exif