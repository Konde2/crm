FROM php:8.4-fpm

# Установка зависимостей ОС
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql intl zip opcache \
    && pecl install redis && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Настройка рабочей директории
WORKDIR /var/www/html

# 🔹 Добавляем EXPOSE (для ясности)
EXPOSE 9000

# 🔹 (Опционально) Убедимся, что FPM слушает 0.0.0.0:9000
# В образе php:*-fpm это уже так, но можно явно проверить:
# Конфиг по умолчанию: /usr/local/etc/php-fpm.d/www.conf
# Там должно быть: listen = 9000 (а не 127.0.0.1:9000)

# Запуск PHP-FPM
CMD ["php-fpm"]