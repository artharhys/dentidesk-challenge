@echo off

REM Verificar PHP
where php >nul 2>&1
if %errorlevel% neq 0 (
    echo Error: PHP no esta instalado
    exit /b 1
)

REM Verificar Composer
where composer >nul 2>&1
if %errorlevel% neq 0 (
    echo Error: Composer no esta instalado
    echo Descarga el instalador desde: https://getcomposer.org/download/
    exit /b 1
)

REM Instalar dependencias
if not exist vendor (
    composer install
)

REM Configurar .env
if not exist .env (
    if exist .env.example (
        copy .env.example .env
    )
    php artisan key:generate --force
)

REM Verificar Docker
where docker >nul 2>&1
if %errorlevel% neq 0 (
    echo Error: Docker no esta instalado
    exit /b 1
)

REM Levantar con Laravel Sail
vendor\bin\sail.bat up -d

REM Esperar a que MySQL este listo y ejecutar migraciones
timeout /t 5 /nobreak >nul
vendor\bin\sail.bat artisan migrate --force

echo Proyecto disponible en: http://localhost

