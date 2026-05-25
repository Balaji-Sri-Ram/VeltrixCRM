FROM richarvey/nginx-php-fpm:3.1.6

# Set working directory
WORKDIR /var/www/html

# Copy nginx configuration
COPY conf/nginx/nginx-site.conf /etc/nginx/sites-available/default.conf
COPY conf/nginx/nginx-site.conf /etc/nginx/sites-enabled/default.conf

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Build front-end assets (if using Vite/Mix)
RUN apk add --no-cache nodejs npm
RUN npm install
RUN npm run build

# Expose port
EXPOSE 80
