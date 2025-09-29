# Use a PHP image with MongoDB, MySQL, and Composer
FROM shivammathur/php:8.2-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Fix permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Install dependencies
RUN composer install --optimize-autoloader --no-interaction

# Expose Apache port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
