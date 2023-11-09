FROM php:8.1-fpm-buster
ARG TIMEZONE

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

# Install required packages
RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    librabbitmq-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libxml2-dev  # Added for SOAP extension

# Install and enable PHP extensions
RUN pecl install amqp && docker-php-ext-enable amqp
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN docker-php-ext-install pdo \
    pdo_mysql  \
    zip  \
    xsl  \
    gd  \
    intl \
    opcache \
    exif \
    mbstring \
    sysvsem \
    sockets \
    soap  # Added SOAP extension here

RUN pecl install raphf \
    && docker-php-ext-enable raphf
#RUN docker-php-ext-enable propro
#RUN docker-php-ext-enable http

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug  \
    && echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Set aliases and timezone
RUN echo 'alias sf="php bin/console"' >> ~/.bashrc \
    && ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/symfony
