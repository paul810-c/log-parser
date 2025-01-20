# Base PHP image
FROM php:8.2-fpm

# Set working directory
WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install pdo_pgsql mbstring xml opcache

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /app

# Set permissions
RUN chown -R www-data:www-data /app

# Expose port
EXPOSE 8000

# Start Symfony server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]