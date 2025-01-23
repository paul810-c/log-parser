FROM php:8.2-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    librabbitmq-dev \
    libssl-dev \
    && docker-php-ext-install pdo_pgsql mbstring xml opcache sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

COPY . /app

RUN chown -R www-data:www-data /app

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
