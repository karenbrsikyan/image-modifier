FROM php:8.1-fpm

ARG USER
ARG USER_ID
ARG GROUP_ID

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    vim \
    unzip \
    libicu-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    libzip-dev \
    zlib1g-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install the PHP gd library
RUN docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp && \
    docker-php-ext-install gd && \
    docker-php-ext-enable gd

# Install the PHP zip library
RUN docker-php-ext-install zip && docker-php-ext-enable zip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

RUN groupadd --force -g $GROUP_ID $USER
RUN useradd -ms /bin/bash --no-user-group -g $GROUP_ID -u 1337 $USER
RUN usermod -u $USER_ID $USER

USER $USER
