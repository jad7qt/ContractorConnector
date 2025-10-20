# Use official PHP 8 image with Apache
FROM php:8.3.27RC1-apache

# Install PHP extensions you need (mysqli, pdo_mysql)
RUN docker-php-ext-install mysqli pdo_mysql

# Enable mod_rewrite (if your app uses URL rewrites)
RUN a2enmod rewrite

# Copy your application code into the container
COPY ./ /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Adjust ownership & permissions if needed
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80