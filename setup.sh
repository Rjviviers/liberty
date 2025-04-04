#!/bin/bash

# Liberty Docker Setup Script
echo "🚀 Setting up Liberty application with Docker..."

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker and Docker Compose first."
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

# Create .env file from .env.docker
echo "📝 Creating .env file from .env.docker..."
cp .env.docker .env
echo "✅ .env file created successfully."

# Create necessary directories if they don't exist
echo "📁 Creating necessary directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
echo "✅ Directories created successfully."

# Set proper permissions
echo "🔒 Setting proper permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
echo "✅ Permissions set successfully."

# Start Docker containers
echo "🐳 Starting Docker containers..."
docker-compose up -d
echo "✅ Docker containers started successfully."

# Wait for containers to be ready
echo "⏳ Waiting for containers to be ready..."
sleep 10

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
docker exec -it liberty-app composer install
echo "✅ Composer dependencies installed successfully."

# Generate application key
echo "🔑 Generating application key..."
docker exec -it liberty-app php artisan key:generate --no-interaction
echo "✅ Application key generated successfully."

# Run database migrations
echo "🗄️ Running database migrations..."
docker exec -it liberty-app php artisan migrate --force
echo "✅ Database migrations completed successfully."

# Create storage link
echo "🔗 Creating storage link..."
docker exec -it liberty-app php artisan storage:link
echo "✅ Storage link created successfully."

# Build frontend assets
echo "🎨 Building frontend assets..."
docker exec -it liberty-node sh -c "npm install && npm run build"
echo "✅ Frontend assets built successfully."

echo "🎉 Liberty application has been successfully set up!"
echo "📱 You can access the application at: http://localhost"
