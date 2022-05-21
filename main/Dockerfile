FROM php:8.1.0-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/html/

WORKDIR /var/www/html

# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo_mysql zip exif pcntl gd memcached

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    lua-zlib-dev \
    libmemcached-dev \
    nginx

# RUN apt-get install -y supervisor

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy code to /var/www
COPY --chown=www:www-data . /var/www/html

# add root to www group
RUN chmod -R ug+w /var/www/html/storage

# Copy nginx/php/supervisor configs
# RUN cp docker/supervisor.conf /etc/supervisord.conf
# RUN cp docker/php.ini /usr/local/etc/php/conf.d/app.ini
# RUN cp docker/nginx.conf /etc/nginx/sites-enabled/default

# PHP Error Log Files
RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

RUN pecl install mongodb
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

# Deployment steps
# RUN composer install --ignore-platform-reqs
RUN chmod +x /var/www/html/docker/run.sh
RUN /var/www/html/docker/run.sh
# ENTRYPOINT ["/var/www/docker/run.sh"]

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Add UID '1000' to www-data
# RUN usermod -u 1000 www-data 

# Copy existing application directory permissions
# COPY --chown=www-data:www-data . /var/www/html

# Change current user to www
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
# RUN apt-get update
# RUN apt-get install -y autoconf pkg-config libssl-dev
# RUN docker-php-ext-install pdo pdo_mysql sockets mysqli
# RUN curl -sS https://getcomposer.org/installer | php -- \
#      --install-dir=/usr/local/bin --filename=composer

# COPY . .
# RUN composer install --ignore-platform-reqs
