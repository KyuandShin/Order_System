FROM php:8.3-apache

# Enable MySQLi extension required for this project
RUN docker-php-ext-install mysqli

# Copy all application files
COPY . /var/www/html/

# Set correct file permissions for Apache
RUN chown -R www-data:www-data /var/www/html/

# Expose web server port
EXPOSE 80