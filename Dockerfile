FROM php:8.2-apache

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite (helps with navigation/routing)
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/

# Set permissions so Apache can read your files
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80