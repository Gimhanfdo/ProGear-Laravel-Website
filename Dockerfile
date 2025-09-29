FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
        libssl-dev \
        pkg-config \
        libcurl4-openssl-dev \
        libpng-dev \
        libonig-dev \
        unzip \
        git \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project
COPY . .

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && composer install --optimize-autoloader --no-interaction

EXPOSE 80
CMD ["apache2-foreground"]
