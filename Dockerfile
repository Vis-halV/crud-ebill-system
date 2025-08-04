# Use official PHP 8.2 image with Apache
FROM php:8.2-apache

# Install PHP extensions and basic tools
RUN apt-get update && apt-get install -y \
    git \
    nano \
    unzip \
    curl \
    && docker-php-ext-install mysqli \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files into the container
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 (handled by base image but explicit here)
EXPOSE 80
