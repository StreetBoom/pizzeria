FROM php:8.3-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y curl \
        libfreetype6-dev \
        libssl-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        libpq-dev \
        libmcrypt-dev \
        libmemcached-tools \
        libmemcached-dev \
        libxml2-dev \
        && pecl install mcrypt-1.0.7 && docker-php-ext-enable mcrypt \
    #   && pecl install memcached && docker-php-ext-enable memcached \
        && docker-php-ext-install -j$(nproc) iconv mbstring pdo pdo_pgsql pgsql zip sockets \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-install intl \
        && docker-php-ext-install soap \
        && docker-php-ext-install pcntl \
        && docker-php-ext-install bcmath \
        && pecl install redis && docker-php-ext-enable redis


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY php.ini /usr/local/etc/php/conf.d/custom.ini
COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html

CMD ["php-fpm"]


