FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libxml2-dev \
    wget \
    default-mysql-client

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get update && apt-get install -y nodejs

# Add user for application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Create necessary directories and set permissions
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache \
    && chown -R www:www /var/www

# Copy composer files first for better caching
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application
COPY --chown=www:www . /var/www

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Set proper permissions
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]