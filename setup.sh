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

# Check if required ports are available
echo "🔌 Checking if required ports are available..."

# Detect OS and use appropriate port checking script
if [[ "$OSTYPE" == "msys" || "$OSTYPE" == "win32" ]]; then
    # Windows - use PowerShell script
    powershell.exe -ExecutionPolicy Bypass -File "./docker/check-ports.ps1"
    if [ $? -ne 0 ]; then
        echo "❌ Setup aborted due to port conflicts."
        exit 1
    fi
else
    # Linux/Mac - use Bash script
    chmod +x docker/check-ports.sh
    ./docker/check-ports.sh
    if [ $? -ne 0 ]; then
        echo "❌ Setup aborted due to port conflicts."
        exit 1
    fi
fi

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

# Prepare and run database migrations
echo "🗄️ Preparing database migrations..."
docker exec -it liberty-app bash -c "chmod +x /var/www/docker/prepare-migrations.sh && /var/www/docker/prepare-migrations.sh"
echo "✅ Migration preparation completed successfully."

# Test migrations before running them
echo "🚨 Testing migrations..."
docker exec -it liberty-app bash -c "chmod +x /var/www/docker/test-migrations.sh && /var/www/docker/test-migrations.sh"
echo "✅ Migration test completed successfully."

echo "🗄️ Running database migrations..."
docker exec -it liberty-app php artisan migrate --force
echo "✅ Database migrations completed successfully."

# Seed the database with initial data
echo "🌱 Seeding the database with initial data..."
docker exec -it liberty-app php artisan db:seed
echo "✅ Database seeding completed successfully."

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
