FROM php:8.4-apache

# Aggiorna pacchetti e installa dipendenze sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Abilita rewrite e installa estensioni PHP
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli pdo_mysql pdo zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install XDebug 
RUN pecl install xdebug && docker-php-ext-enable xdebug

# --- NUOVA SEZIONE: Configurazione Apache DocumentRoot ---
ENV APACHE_DOCUMENT_ROOT /var/www/html/src/api/php

# Aggiorna i virtual host di default di Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
# Aggiorna la configurazione di directory di Apache
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# --------------------------------------------------------

# Imposta la directory di lavoro (puoi lasciarla sulla root del progetto)
WORKDIR /var/www/html