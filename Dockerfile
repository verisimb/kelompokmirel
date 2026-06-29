# ============================================================
# Stage 1: Node.js - Build frontend assets
# ============================================================
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --frozen-lockfile

COPY . .
RUN npm run build

# ============================================================
# Stage 2: Composer - Install PHP dependencies
# ============================================================
FROM composer:2 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
        --no-interaction \
        --no-progress \
        --prefer-source \
        --optimize-autoloader \
        --no-scripts

# ============================================================
# Stage 3: Production image
# ============================================================
FROM php:8.2-fpm AS production

# ─── System dependencies ─────────────────────────────────────
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    supervisor \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ─── PHP production config ────────────────────────────────────
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Override selected PHP ini values for Laravel
RUN echo "upload_max_filesize = 50M" >> "$PHP_INI_DIR/conf.d/laravel.ini" \
 && echo "post_max_size = 50M"       >> "$PHP_INI_DIR/conf.d/laravel.ini" \
 && echo "memory_limit = 256M"       >> "$PHP_INI_DIR/conf.d/laravel.ini" \
 && echo "max_execution_time = 300"  >> "$PHP_INI_DIR/conf.d/laravel.ini" \
 && echo "opcache.enable = 1"        >> "$PHP_INI_DIR/conf.d/laravel.ini" \
 && echo "opcache.memory_consumption = 128" >> "$PHP_INI_DIR/conf.d/laravel.ini" \
 && echo "opcache.validate_timestamps = 0"  >> "$PHP_INI_DIR/conf.d/laravel.ini"

# ─── Application files ────────────────────────────────────────
WORKDIR /var/www/html

# 1. Copy all application source code
COPY . .

# 2. Override vendor with composer-built (production, no-dev)
COPY --from=composer-builder /app/vendor ./vendor

# 3. Override public/build with freshly compiled Vite assets
COPY --from=node-builder /app/public/build ./public/build

# ─── Nginx configuration ─────────────────────────────────────
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
# Remove default nginx site
RUN rm -f /etc/nginx/sites-enabled/default

# ─── Supervisor configuration ────────────────────────────────
RUN mkdir -p /var/log/supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ─── Entrypoint ──────────────────────────────────────────────
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# ─── Storage & Cache directories ─────────────────────────────
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# ─── Expose & Run ────────────────────────────────────────────
EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
