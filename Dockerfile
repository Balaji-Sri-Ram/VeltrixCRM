# Stage 1: Build front-end assets with Node 20
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Serve application with PHP 8.2 and Nginx
FROM serversideup/php:8.2-fpm-nginx

# Tell the image where Laravel's public folder is
ENV WEB_DOCUMENT_ROOT=/var/www/html/public

# Switch to root so we can install dependencies and set permissions
USER root

# Set working directory
WORKDIR /var/www/html

# Copy all application files
COPY . .

# Copy the built Vite assets from the Node stage
COPY --from=node_builder /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions for Laravel
RUN chown -R webuser:webgroup /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/build

# Switch back to the secure, unprivileged user for running the app
USER webuser
