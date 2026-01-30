# Multi-stage Dockerfile for Opticas-Development
# Base: Official PHP-FPM 8.1 Alpine image

# ========================================
# Stage 1: Base PHP-FPM Image
# ========================================
FROM php:8.1-fpm-alpine AS php-base

# Install system dependencies
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libonig-dev \
    icu-dev \
    libxml2-dev \
    oniguruma-dev \
    autoconf \
    g++ \
    make \
    postgresql-dev \
    linux-headers

# Install PHP extensions
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        intl \
        pdo_mysql \
        mysqli \
        zip \
        gd \
        exif \
        opcache \
        mbstring \
        bcmath \
        pcntl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create application user
RUN addgroup -g 1000 www && \
    adduser -D -u 1000 -G www www

# Set working directory
WORKDIR /var/www/html

# ========================================
# Stage 2: Production Image
# ========================================
FROM php:8.1-fpm-alpine AS production

# Copy extensions from base stage
COPY --from=php-base /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
COPY --from=php-base /usr/local/lib/php/extensions /usr/local/lib/php/extensions

# Copy Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install system dependencies for runtime
RUN apk add --no-cache \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    libonig \
    icu-libs \
    libxml2

# Create application user
RUN addgroup -g 1000 www && \
    adduser -D -u 1000 -G www www

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY --chown=www:www . /var/www/html

# Install dependencies (production)
RUN composer install --no-dev --no-autoloader --optimize-autoloader

# Generate autoload
RUN composer dump-autoload --optimize --classmap-authoritative

# Create writable directories and set permissions
RUN mkdir -p \
        /var/www/html/writable/cache \
        /var/www/html/writable/logs \
        /var/www/html/writable/session \
        /var/www/html/writable/uploads \
        /var/www/html/public/uploads \
    && chown -R www:www /var/www/html/writable \
    && chown -R www:www /var/www/html/public/uploads \
    && find /var/www/html/writable -type d -exec chmod 775 {} \; \
    && find /var/www/html/writable -type f -exec chmod 664 {} \;

# Expose PHP-FPM port
EXPOSE 9000

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s --retries=3 \
    CMD php-fpm-healthcheck || exit 1

# Start PHP-FPM with custom configuration
CMD ["php-fpm", "-F", "-R", "-O", "/usr/local/etc/php-fpm.d"]

# ========================================
# Stage 3: Development Image
# ========================================
FROM php-base AS development

# Install additional dev tools
RUN apk add --no-cache \
    bash \
    curl \
    vim \
    supervisor \
    zip

# Create application user
RUN addgroup -g 1000 www && \
    adduser -D -u 1000 -G www www

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY --chown=www:www . /var/www/html

# Install dependencies (dev)
RUN composer install --prefer-dist

# Create writable directories and set permissions
RUN mkdir -p \
        /var/www/html/writable/cache \
        /var/www/html/writable/logs \
        /var/www/html/writable/session \
        /var/www/html/writable/uploads \
        /var/www/html/public/uploads \
    && chown -R www:www /var/www/html/writable \
    && chown -R www:www /var/www/html/public/uploads \
    && chmod -R 777 /var/www/html/writable

# Expose PHP-FPM port
EXPOSE 9000

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s --retries=3 \
    CMD php-fpm-healthcheck || exit 1

# Start PHP-FPM
CMD ["php-fpm", "-F", "-R", "-O", "/usr/local/etc/php-fpm.d"]
