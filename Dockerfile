FROM php:8.3-apache

# Install required system libraries first
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Enable database extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql

# Copy all application files
COPY . /var/www/html/

# Set correct file permissions for Apache
RUN chown -R www-data:www-data /var/www/html/

# Expose web server port
EXPOSE 80
