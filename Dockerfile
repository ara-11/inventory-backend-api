# Use the official PHP image with Apache
FROM php:8.1-apache

# Enable mod_rewrite (optional but useful for REST APIs)
RUN a2enmod rewrite

# Copy all your PHP files to the Apache web root
COPY . /var/www/html/

# Set permissions (optional but good practice)
RUN chown -R www-data:www-data /var/www/html
