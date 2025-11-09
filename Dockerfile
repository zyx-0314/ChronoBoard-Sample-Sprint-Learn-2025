FROM yiisoftware/yii2-php:8.2-apache

# Set working directory
WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install composer dependencies (skip dev dependencies that require PHP 8.3+)
RUN composer install --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-dev || \
    composer update --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-dev

# Copy application files
COPY . /app

# Set permissions for runtime and web assets directories
RUN chown -R www-data:www-data /app/runtime /app/web/assets 2>/dev/null || true

# Expose port 80 for Apache web server
EXPOSE 80
