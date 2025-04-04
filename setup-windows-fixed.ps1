# Windows-specific setup script for Liberty application
# This script sets up the Liberty application using Docker Desktop for Windows

# Define colors for output
function Write-ColorOutput {
    param (
        [string]$Text,
        [string]$Color = "White"
    )

    Write-Host $Text -ForegroundColor $Color
}

# Check if Docker Desktop is installed and running
function Test-DockerDesktop {
    Write-ColorOutput "Checking if Docker Desktop is installed and running..." "Yellow"

    try {
        $null = docker version
        if ($LASTEXITCODE -ne 0) {
            Write-ColorOutput "Docker Desktop is not running. Please start Docker Desktop and try again." "Red"
            exit 1
        }

        Write-ColorOutput "Docker Desktop is running." "Green"
        return $true
    }
    catch {
        Write-ColorOutput "Docker Desktop is not installed or not in PATH. Please install Docker Desktop for Windows." "Red"
        Write-ColorOutput "Download from: https://www.docker.com/products/docker-desktop/" "Yellow"
        exit 1
    }
}

# Create .env file from .env.docker.windows
function New-EnvFile {
    Write-ColorOutput "Creating .env file from .env.docker.windows..." "Yellow"

    if (Test-Path ".env.docker.windows") {
        Copy-Item ".env.docker.windows" ".env" -Force
        Write-ColorOutput ".env file created successfully." "Green"
    }
    elseif (Test-Path ".env.docker") {
        Copy-Item ".env.docker" ".env" -Force
        Add-Content ".env" "`nCOMPOSE_CONVERT_WINDOWS_PATHS=1"
        Write-ColorOutput ".env file created successfully (using .env.docker with Windows modifications)." "Green"
    }
    else {
        Write-ColorOutput ".env.docker.windows and .env.docker files not found. Please make sure you're running this script from the project root directory." "Red"
        exit 1
    }
}

# Create necessary directories
function New-Directories {
    Write-ColorOutput "Creating necessary directories..." "Yellow"

    $directories = @(
        "storage/app/public",
        "storage/framework/cache",
        "storage/framework/sessions",
        "storage/framework/views",
        "storage/logs",
        "bootstrap/cache"
    )

    foreach ($dir in $directories) {
        if (-not (Test-Path $dir)) {
            New-Item -ItemType Directory -Path $dir -Force | Out-Null
        }
    }

    Write-ColorOutput "Directories created successfully." "Green"
}

# Check if required ports are available
function Test-Ports {
    Write-ColorOutput "Checking if required ports are available..." "Yellow"

    $portsScript = Join-Path -Path $PSScriptRoot -ChildPath "docker\check-ports.ps1"
    if (Test-Path $portsScript) {
        & powershell.exe -ExecutionPolicy Bypass -File $portsScript
        if ($LASTEXITCODE -ne 0) {
            Write-ColorOutput "Setup aborted due to port conflicts." "Red"
            exit 1
        }
    }
    else {
        Write-ColorOutput "Port checking script not found. Continuing without port checks." "Yellow"
    }
}

# Start Docker containers
function Start-DockerContainers {
    Write-ColorOutput "Starting Docker containers with Windows configuration..." "Yellow"

    docker-compose -f docker-compose.windows.yml up -d
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to start Docker containers. Please check the error messages above." "Red"
        exit 1
    }

    Write-ColorOutput "Docker containers started successfully." "Green"
}

# Wait for containers to be ready
function Wait-ForContainers {
    Write-ColorOutput "Waiting for containers to be ready..." "Yellow"

    # Wait for 15 seconds to ensure containers are fully started
    Start-Sleep -Seconds 15
}

# Install Composer dependencies
function Install-ComposerDependencies {
    Write-ColorOutput "Installing Composer dependencies..." "Yellow"

    docker exec -it liberty-app composer install
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to install Composer dependencies. Please check the error messages above." "Red"
        exit 1
    }

    Write-ColorOutput "Composer dependencies installed successfully." "Green"
}

# Generate application key
function New-ApplicationKey {
    Write-ColorOutput "Generating application key..." "Yellow"

    docker exec -it liberty-app php artisan key:generate --no-interaction
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to generate application key. Please check the error messages above." "Red"
        exit 1
    }

    Write-ColorOutput "Application key generated successfully." "Green"
}

# Prepare and run database migrations
function Invoke-Migrations {
    Write-ColorOutput "Preparing database migrations..." "Yellow"

    docker exec -it liberty-app bash -c "chmod +x /var/www/docker/prepare-migrations.sh && /var/www/docker/prepare-migrations.sh"
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to prepare migrations. Please check the error messages above." "Red"
        exit 1
    }

    Write-ColorOutput "Migration preparation completed successfully." "Green"

    Write-ColorOutput "Testing migrations..." "Yellow"
    docker exec -it liberty-app bash -c "chmod +x /var/www/docker/test-migrations.sh && /var/www/docker/test-migrations.sh"
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Migration test failed. Please check the error messages above." "Red"
        exit 1
    }

    Write-ColorOutput "Migration test completed successfully." "Green"

    Write-ColorOutput "Running database migrations..." "Yellow"
    docker exec -it liberty-app php artisan migrate --force
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to run migrations. Please check the error messages above." "Red"
        exit 1
    }

    Write-ColorOutput "Database migrations completed successfully." "Green"
}

# Seed the database
function Invoke-DatabaseSeed {
    Write-ColorOutput "Seeding the database with initial data..." "Yellow"

    docker exec -it liberty-app php artisan db:seed
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to seed the database. Please check the error messages above." "Red"
        exit 1
    }

    Write-ColorOutput "Database seeding completed successfully." "Green"
}

# Create storage link
function New-StorageLink {
    Write-ColorOutput "Creating storage link..." "Yellow"

    docker exec -it liberty-app php artisan storage:link
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to create storage link. Please check the error messages above." "Red"
        exit 1
    }

    Write-ColorOutput "Storage link created successfully." "Green"
}

# Build frontend assets
function Build-FrontendAssets {
    Write-ColorOutput "Building frontend assets..." "Yellow"

    docker exec -it liberty-node sh -c "npm install && npm run build"
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to build frontend assets. Please check the error messages above." "Red"
        exit 1
    }

    Write-ColorOutput "Frontend assets built successfully." "Green"
}

# Main function
function Start-Setup {
    Write-ColorOutput "🚀 Setting up Liberty application with Docker on Windows..." "Cyan"

    # Check if Docker Desktop is installed and running
    Test-DockerDesktop

    # Create .env file from .env.docker
    New-EnvFile

    # Create necessary directories
    New-Directories

    # Check if required ports are available
    Test-Ports

    # Start Docker containers
    Start-DockerContainers

    # Wait for containers to be ready
    Wait-ForContainers

    # Install Composer dependencies
    Install-ComposerDependencies

    # Generate application key
    New-ApplicationKey

    # Prepare and run database migrations
    Invoke-Migrations

    # Seed the database
    Invoke-DatabaseSeed

    # Create storage link
    New-StorageLink

    # Build frontend assets
    Build-FrontendAssets

    # Display success message
    Write-ColorOutput "🎉 Liberty application has been successfully set up!" "Green"
    Write-ColorOutput "📱 You can access the application at: http://localhost:5412" "Cyan"
}

# Run the main function
Start-Setup
