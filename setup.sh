#!/bin/bash

echo "🚀 Flight3D Vision - Setup Script"
echo "=================================="
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "📝 Copying .env.example to .env..."
    cp .env.example .env
else
    echo "✅ .env already exists"
fi

# Install Composer dependencies
echo ""
echo "📦 Installing Composer dependencies..."
composer install

# Install NPM dependencies
echo ""
echo "📦 Installing NPM dependencies..."
npm install

# Generate application key
echo ""
echo "🔑 Generating application key..."
php artisan key:generate

# Create SQLite database
echo ""
echo "💾 Creating SQLite database..."
touch database/database.sqlite

# Run migrations
echo ""
echo "🗃️  Running migrations..."
php artisan migrate

# Run seeders
echo ""
echo "🌱 Seeding database..."
php artisan db:seed

# Build assets
echo ""
echo "🎨 Building frontend assets..."
npm run build

echo ""
echo "✨ Setup complete!"
echo ""
echo "To start the application:"
echo "  1. Run: php artisan serve"
echo "  2. In another terminal, run: npm run dev"
echo "  3. Access: http://localhost:8000"
echo ""
