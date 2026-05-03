# Use the official PHP image with Apache
FROM php:8.2-apache

# Install the MySQL extensions PHP needs to talk to the database
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy your project files into the container's web directory
COPY . /var/www/html/

# Expose port 80 for Render
EXPOSE 80