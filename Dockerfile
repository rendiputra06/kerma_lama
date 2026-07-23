FROM php:7.4-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip

# Enable Apache Mod Rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Create missing upload directories and set permissions
RUN mkdir -p uploads/kerma uploads/panduan uploads/kegiatan uploads/penerapan \
    && chmod -R 777 uploads \
    && chmod -R 777 application/modules
