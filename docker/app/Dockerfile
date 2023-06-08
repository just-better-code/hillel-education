FROM php:8-fpm

# Install general dependencies
RUN apt-get update -y -q && \
    apt-get install -q -y \
    wget \
    git \
    nano \
    mc \
    supervisor \
    cron \
    zip \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libcurl4-openssl-dev \
    libc-client-dev \
    libkrb5-dev \
    libonig-dev \
    libxml2-dev && \
    rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install composer
RUN wget -O composer-setup.php https://getcomposer.org/installer && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Install xdebug
ARG XDEBUG_MODE
RUN if [ ! "$XDEBUG_MODE" = "off" ] ; then \
      pecl install xdebug && \
      docker-php-ext-enable xdebug; \
    fi

ARG DOCKER_APP_DIR
WORKDIR $DOCKER_APP_DIR

#EXPOSE 9000

ENTRYPOINT ["./docker/app/entrypoint.sh"]
