FROM php:8.5-fpm

ENV COMPOSER_MEMORY_LIMIT='-1'
ENV PS1="\u@\h:\w\\$ "
ENV TZ="Asia/Jakarta"

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        libmemcached-dev \
        libmcrypt-dev \
        libreadline-dev \
        libgmp-dev \
        libzip-dev \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        libxml2-dev \
        libicu-dev \
        libsasl2-dev \
        openssh-server \
        libmagickwand-dev \
        git \
        cron \
        nano \
        curl \
        unzip \
        zip && \
    docker-php-ext-install \
        soap \
        exif \
        pcntl \
        intl \
        gmp \
        zip \
        pdo_mysql \
        pdo_pgsql \
        bcmath \
        sockets && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

#####################################
# PHPRedis:
#####################################
RUN pecl install redis && docker-php-ext-enable redis

#####################################
# MongoDB:
#####################################
RUN pecl install mongodb && docker-php-ext-enable mongodb

#####################################
# Imagick:
#####################################
RUN pecl install imagick && docker-php-ext-enable imagick

#####################################
# xDebug:
#####################################
RUN pecl install xdebug

#####################################
# PHP Memcached:
#####################################
RUN pecl install memcached && docker-php-ext-enable memcached

#####################################
# Composer:
#####################################
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

#####################################
# Laravel Schedule Cron Job:
#####################################
RUN echo "* * * * * root /usr/local/bin/php /var/www/html/artisan schedule:run >> /dev/null 2>&1" >> /etc/cron.d/laravel-scheduler && \
    chmod 0644 /etc/cron.d/laravel-scheduler

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

ADD ./local.ini /usr/local/etc/php/conf.d

#####################################
# Aliases:
#####################################
RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/vendor/bin/dep "$@"' > /usr/bin/dep && \
    chmod +x /usr/bin/dep

RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/html/artisan "$@"' > /usr/bin/art && \
    chmod +x /usr/bin/art

RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/html/artisan migrate "$@"' > /usr/bin/migrate && \
    chmod +x /usr/bin/migrate

RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/html/artisan migrate:fresh --seed' > /usr/bin/fresh && \
    chmod +x /usr/bin/fresh

RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/html/artisan config:clear\n/var/www/vendor/bin/phpunit -d memory_limit=2G --stop-on-error --stop-on-failure --testdox-text=tests/report.txt "$@"' > /usr/bin/t && \
    chmod +x /usr/bin/t

RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/html/artisan config:clear\n/bin/bash\n/usr/local/bin/php /var/www/html/artisan dusk -d memory_limit=2G --stop-on-error --stop-on-failure --testdox-text=tests/report-dusk.txt "$@"' > /usr/bin/d && \
    chmod +x /usr/bin/d

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY ./docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh && \
    ln -s /usr/local/bin/docker-entrypoint.sh /

ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 9000

CMD ["php-fpm"]