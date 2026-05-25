# Stage 1: Build front-end assets with Node 20
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Serve application with PHP-FPM and Nginx
FROM richarvey/nginx-php-fpm:3.1.6

# Tell the image where Laravel's public folder is
ENV WEBROOT=/var/www/html/public

# Set working directory
WORKDIR /var/www/html

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
