FROM debian:bullseye

LABEL MAINTAINER="Anton Kulinich"
LABEL DESCRIPTION="Image for learning in Hillel school"
ARG DOCKER_APP_DIR
ARG DOCKER_ENABLE_XDEBUG
WORKDIR $DOCKER_APP_DIR

# Install general dependencies
RUN apt-get update -y -q && \
    apt-get install -y -q wget gnupg2 lsb-release && \
    wget https://packages.sury.org/php/apt.gpg && apt-key add apt.gpg && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list && \
    apt-get update -y && \
    apt-get install -q -y \
    php8.2-fpm \
    php8.2-zip \
    php8.2-gd \
    php8.2-curl \
    php8.2-mysql \
    php8.2-imap \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-bcmath \
    git \
    nano \
    mc \
    supervisor \
    cron \
    unzip \
    libzip-dev \
    libpng-dev \
    libcurl4-openssl-dev \
    libc-client-dev \
    libkrb5-dev \
    libonig-dev \
    libxml2-dev \
    rsyslog && \
    rm -rf /var/lib/apt/lists/*

# Install composer
RUN wget -O composer-setup.php https://getcomposer.org/installer && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Install xdebug
ARG DOCKER_ENABLE_XDEBUG
RUN if [ "$DOCKER_ENABLE_XDEBUG" = "1" ] ; then \
      apt-get update -y -q && \
      apt-get install -y -q php8.2-xdebug && \
      rm -rf /var/lib/apt/lists/*; \
    fi

ENTRYPOINT ["./docker/app/entrypoint.sh"]
