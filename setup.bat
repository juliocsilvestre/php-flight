@echo off
echo 🚀 Flight3D Vision - Setup Script
echo ==================================
echo.

REM Check if .env exists
if not exist .env (
    echo 📝 Copying .env.example to .env...
    copy .env.example .env
) else (
    echo ✅ .env already exists
)

REM Install Composer dependencies
echo.
echo 📦 Installing Composer dependencies...
call composer install

REM Install NPM dependencies
echo.
echo 📦 Installing NPM dependencies...
call npm install

REM Generate application key
echo.
echo 🔑 Generating application key...
call php artisan key:generate

REM Create SQLite database
echo.
echo 💾 Creating SQLite database...
type nul > database\database.sqlite

REM Run migrations
echo.
echo 🗃️  Running migrations...
call php artisan migrate

REM Run seeders
echo.
echo 🌱 Seeding database...
call php artisan db:seed

REM Build assets
echo.
echo 🎨 Building frontend assets...
call npm run build

echo.
echo ✨ Setup complete!
echo.
echo To start the application:
echo   1. Run: php artisan serve
echo   2. In another terminal, run: npm run dev
echo   3. Access: http://localhost:8000
echo.
pause
