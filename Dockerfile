# 1️⃣ Use PHP 8.2 with Apache
FROM php:8.2-apache

# 2️⃣ Install system dependencies
RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev \
    libpng-dev \
    libonig-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# 3️⃣ Enable Apache rewrite
RUN a2enmod rewrite

# 4️⃣ Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 5️⃣ Set working directory
WORKDIR /var/www/html

# 6️⃣ Copy Laravel project files
COPY . .

# 7️⃣ Fix permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# 8️⃣ Install PHP dependencies (after extensions are installed)
RUN composer install --optimize-autoloader --no-interaction

# 9️⃣ Expose Apache port
EXPOSE 80

# 🔟 Start Apache
CMD ["apache2-foreground"]
