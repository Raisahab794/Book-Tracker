# Use an official PHP image as the base image
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies for PHP extensions and Composer
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    curl \
    libxml2-dev \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer (PHP Dependency Manager)
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Copy your application files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set up environment variables (like database credentials, etc.)
ENV APP_KEY=YOUR_APP_KEY

# Expose the port Laravel will listen on
EXPOSE 9000

# Command to run PHP-FPM server
CMD ["php-fpm"]
