#!/bin/bash

# Verificar PHP
if ! command -v php &> /dev/null; then
    echo "Error: PHP no está instalado"
    exit 1
fi

# Verificar Composer
if ! command -v composer &> /dev/null; then
    echo "Instalando Composer..."
    curl -sS https://getcomposer.org/installer | php
    if [ -f composer.phar ]; then
        sudo mv composer.phar /usr/local/bin/composer
        chmod +x /usr/local/bin/composer
    else
        echo "Error: No se pudo instalar Composer"
        exit 1
    fi
fi

# Instalar dependencias
if [ ! -d "vendor" ]; then
    composer install
fi

# Configurar .env
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
    fi
    php artisan key:generate --force
fi

# Verificar Docker
if ! command -v docker &> /dev/null; then
    echo "Error: Docker no está instalado"
    exit 1
fi

# Levantar con Laravel Sail
./vendor/bin/sail up -d

# Esperar a que MySQL esté listo y ejecutar migraciones
sleep 5
./vendor/bin/sail artisan migrate --force

echo "Proyecto disponible en: http://localhost"
