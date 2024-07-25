FROM php:8.3-fpm
WORKDIR "/application"

# Install selected extensions and other stuff
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Install NPM
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash
RUN apt-get install nodejs -y
RUN node -v && npm -v

# Install imagick
RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN apt-get update; \
    apt-get install -y libmagickwand-dev; \
    pecl install imagick; \
    docker-php-ext-enable imagick;

# Remove APT cache
RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Set Warsaw timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Warsaw /etc/localtime
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc