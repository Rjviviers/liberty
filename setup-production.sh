#!/bin/bash

# Liberty Production Docker Setup Script
echo "🚀 Setting up Liberty application for production with Docker..."

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

# Prompt for environment configuration
read -p "Enter your domain name (e.g., example.com): " DOMAIN_NAME
read -p "Enter database password: " DB_PASSWORD
read -p "Enter database username [liberty_user]: " DB_USERNAME
DB_USERNAME=${DB_USERNAME:-liberty_user}
read -p "Enter database name [liberty]: " DB_DATABASE
DB_DATABASE=${DB_DATABASE:-liberty}

# Update .env file with production settings
echo "🔧 Configuring environment for production..."
sed -i "s|APP_URL=http://localhost|APP_URL=https://$DOMAIN_NAME|g" .env
sed -i "s|DB_PASSWORD=liberty_password|DB_PASSWORD=$DB_PASSWORD|g" .env
sed -i "s|DB_USERNAME=liberty_user|DB_USERNAME=$DB_USERNAME|g" .env
sed -i "s|DB_DATABASE=liberty|DB_DATABASE=$DB_DATABASE|g" .env
echo "✅ Environment configured successfully."

# Create necessary directories if they don't exist
echo "📁 Creating necessary directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p docker/nginx/ssl
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
docker-compose -f docker-compose.prod.yml up -d
echo "✅ Docker containers started successfully."

# Wait for containers to be ready
echo "⏳ Waiting for containers to be ready..."
sleep 15

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
docker exec -it liberty-app composer install --optimize-autoloader --no-dev
echo "✅ Composer dependencies installed successfully."

# Generate application key
echo "🔑 Generating application key..."
docker exec -it liberty-app php artisan key:generate --no-interaction
echo "✅ Application key generated successfully."

# Prepare and run database migrations
echo "🗄️ Preparing database migrations..."
docker exec -it liberty-app bash -c "chmod +x /var/www/docker/prepare-migrations.sh && /var/www/docker/prepare-migrations.sh"
echo "✅ Migration preparation completed successfully."

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
docker exec -it liberty-app npm install
docker exec -it liberty-app npm run build
echo "✅ Frontend assets built successfully."

# Optimize Laravel
echo "⚡ Optimizing Laravel..."
docker exec -it liberty-app php artisan config:cache
docker exec -it liberty-app php artisan route:cache
docker exec -it liberty-app php artisan view:cache
echo "✅ Laravel optimized successfully."

echo "🎉 Liberty application has been successfully set up for production!"
echo "📱 You can access the application at: https://$DOMAIN_NAME"
echo ""
echo "⚠️ IMPORTANT: Don't forget to set up SSL certificates for your domain."
echo "You can use Let's Encrypt with Certbot to generate free SSL certificates."
