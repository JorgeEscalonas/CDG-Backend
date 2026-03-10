#!/bin/bash

# Generar cache de configuración y rutas
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones si es necesario
# php artisan migrate --force

# Iniciar Nginx y PHP-FPM
service nginx start
php-fpm
