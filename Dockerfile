# Stage 1: Build front-end assets with Node 20
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Serve application with PHP-FPM and Nginx
FROM richarvey/nginx-php-fpm:3.1.6

# Set working directory
WORKDIR /var/www/html

# Copy nginx configuration
COPY conf/nginx/nginx-site.conf /etc/nginx/sites-available/default.conf
COPY conf/nginx/nginx-site.conf /etc/nginx/sites-enabled/default.conf

# Copy all application files
COPY . .

# Copy the built Vite assets from the Node stage
COPY --from=node_builder /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/build

# Expose port
EXPOSE 80
