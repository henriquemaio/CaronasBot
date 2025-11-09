# Dockerfile - para Render

FROM php:8.2-apache

# Install dependencies and extensions
RUN apt-get update -y \
 && apt-get install -y --no-install-recommends \
    libpq-dev \
 && docker-php-ext-install pdo pdo_pgsql pgsql \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Configure Apache to allow override and define index.php
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
 && echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Copy code
COPY . /var/www/html/

# Adjust permissions
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html

# Default PORT for Render is 10000, but Apache listens on 80 by default.
# We'll reconfigure Apache to listen on the env PORT (if it exists).
ARG PORT=10000
ENV PORT=${PORT}

# Substitute the Apache configuration to use the $PORT
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf \
 && sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-enabled/000-default.conf

# Expose the port (just informational)
EXPOSE ${PORT}

# Standard CMD
CMD ["apache2-foreground"]

