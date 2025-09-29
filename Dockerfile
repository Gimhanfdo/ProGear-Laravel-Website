# Base image
FROM php:8.2-apache

# -----------------------------
# Install system dependencies
# -----------------------------
RUN apt-get update && apt-get install -y \
        libssl-dev \
        pkg-config \
        libcurl4-openssl-dev \
        libpng-dev \
        libonig-dev \
        unzip \
        git \
        nodejs \
        npm \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# -----------------------------
# Set working directory
# -----------------------------
WORKDIR /var/www/html

# -----------------------------
# Copy composer binary from official image
# -----------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -----------------------------
# Copy all project files
# -----------------------------
COPY . .

# -----------------------------
# Install PHP dependencies
# -----------------------------
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# -----------------------------
# Install Node dependencies & build assets
# -----------------------------
RUN npm install
RUN npm run build

# -----------------------------
# Fix permissions
# -----------------------------
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# -----------------------------
# Update Apache to serve from /public
# -----------------------------
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# -----------------------------
# Expose port for Render/Railway
# -----------------------------
EXPOSE 8080

# -----------------------------
# Start Apache in foreground
# -----------------------------
CMD ["apache2-foreground"]
