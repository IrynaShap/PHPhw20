# Dockerfile
FROM php:8.2.6-apache

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application source
COPY . /var/www/html/

# Install dependencies
WORKDIR /var/www/html/
RUN composer install
RUN composer dump-autoload

# Change the Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Expose port 80 to allow communication to/from server
EXPOSE 80

# Run Apache server in the foreground when container runs
CMD ["apache2-foreground"]