@echo off
echo Starting containers...
docker compose up -d

:wait_loop
docker compose exec mysql mysqladmin ping -h127.0.0.1 --silent >nul 2>&1
if errorlevel 1 (
    echo Waiting...
    timeout /t 2 >nul
    goto wait_loop
)

echo Copying .env and generating app key...
docker compose exec app cmd /c "copy .env.docker .env >nul 2>&1 || exit /b 0"

echo Installing PHP dependencies...
docker compose exec app composer install
docker compose exec app php artisan key:generate

echo Running migrations and seeders...
docker compose exec app php artisan migrate --seed

echo Setup complete.
