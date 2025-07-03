
# Use official PHP with Apache
FROM php:8.1-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# ✅ Install PostgreSQL PDO driver
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy app files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80