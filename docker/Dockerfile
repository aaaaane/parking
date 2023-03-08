FROM php:8.2-fpm-alpine

# Install the packages you need
RUN set -ex \
    # Update package list
    && apk update \
    && apk upgrade -q -U -a \
    # Add system dependencies
    && echo "Add system dependencies" \
    && apk add --no-cache \
        linux-headers \
        screen \
        alpine-sdk \
        libpng-dev \
        oniguruma-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        zip \
        jpegoptim optipng pngquant gifsicle \
        vim \
        unzip \
        curl \
        openssh-server \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer self-update \
    # Install PHP Extensions
    && echo "Install PHP Extensions" \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd sockets \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    # Configure user
    && addgroup -S www  \
    && adduser -S www -G www \
    # Create composer install directory
    && mkdir -p /var/www/.composer/cache/vcs \
    && chown -R www:www /var/www/.composer

ENV APCU_URL="https://pecl.php.net/get/apcu-5.1.22.tgz"
RUN docker-php-source extract \
    # ext-apcu
    && mkdir -p /usr/src/php/ext/apcu \
    && curl -fsSL $APCU_URL | tar xvz -C /usr/src/php/ext/apcu --strip 1 \
    && docker-php-ext-install apcu \
    # cleanup
    && docker-php-source delete \

# Copy existing Application directory contents
COPY . /var/www

# Copy existing Application directory permissions
RUN chown -R www:www /var/www

# Change current user to www
USER www

# Set your working directory
WORKDIR /var/www
