FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y libzip-dev zip unzip gzip \
    gcc \
    libpq-dev \
    zlib1g-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    curl \
    git \
    build-essential \
    openssl \
    libssl-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql soap zip gd \
    && cp /usr/local/bin/php /usr/bin/

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Phalcon
WORKDIR /usr/local/src
RUN git clone https://github.com/phalcon/cphalcon.git --branch 4.0.x --single-branch
WORKDIR /usr/local/src/cphalcon/build
RUN ./install

# -------------------- Installing PHP Extension: psr --------------------
RUN set -eux \
	# Installation: Version specific
	# Type:         PECL extension
	# Default:      Pecl command
	&& pecl install psr-1.0.0 \
	# Enabling
	&& docker-php-ext-enable psr \
	&& true


RUN docker-php-ext-install pdo pdo_pgsql

# Install PECL extensions
RUN yes | pecl install psr xdebug-2.9.8 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable phalcon \
    && echo extension=phalcon.so >> /usr/local/etc/php/conf.d/docker-php-ext-phalcon.ini \
    && echo xdebug.remote_enable=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_port=9005 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_autostart=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_handler=dbgp >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_connect_back=0 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_host=host.docker.internal >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.idekey=PHPSTORM >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini