FROM php:8.2-fpm-alpine
# FROM php:8.2-apache

# WORKDIR /var/www/html
RUN docker-php-ext-install pdo pdo_mysql
# Mod Rewrite
# RUN a2enmod rewrite

# Linux Library
# RUN apt-get update -y && apt-get install -y \
#     libicu-dev \
#     libmariadb-dev \
#     unzip zip \
#     zlib1g-dev \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libjpeg62-turbo-dev \
#     libpng-dev 

# # Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP Extension
# RUN docker-php-ext-install gettext intl pdo_mysql gd

# RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
#     && docker-php-ext-install -j$(nproc) gd
# RUN curl -sS https://getcomposer.org/installer | php -- \
#      --install-dir=/usr/local/bin --filename=composer

# WORKDIR /var/www

# Mod Rewrite
# RUN a2enmod rewrite

# RUN apt-get update && apt-get install -y \
# 		libfreetype-dev \
# 		libjpeg62-turbo-dev \
# 		libpng-dev \
# 	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
# 	&& docker-php-ext-install -j$(nproc) gd \
#     && docker-php-ext-install pdo_mysql

# RUN docker-php-ext-install pdo_mysql

# Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer




