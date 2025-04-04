# Liberty Application Starter Script for Windows
# This script starts the Liberty application without Docker

# Define colors for output
function Write-ColorOutput {
    param (
        [string]$Text,
        [string]$Color = "White"
    )
    
    Write-Host $Text -ForegroundColor $Color
}

# Configuration
$APP_PORT = 5412
$DB_PORT = 3306
$VITE_PORT = 5173
$PHP_VERSION = "8.2"
$NODE_VERSION = "20"

# Check if PHP is installed
function Test-PHP {
    Write-ColorOutput "Checking if PHP is installed..." "Yellow"
    
    try {
        $phpVersion = php -v | Select-String -Pattern "PHP ([0-9]+\.[0-9]+)"
        if ($phpVersion) {
            $version = $phpVersion.Matches.Groups[1].Value
            Write-ColorOutput "PHP $version is installed." "Green"
            
            # Check if version is compatible
            if ([double]$version -lt [double]$PHP_VERSION) {
                Write-ColorOutput "Warning: PHP version $version is lower than recommended version $PHP_VERSION." "Yellow"
                Write-ColorOutput "Some features may not work correctly." "Yellow"
            }
            
            return $true
        } else {
            Write-ColorOutput "PHP is installed but version could not be determined." "Yellow"
            return $true
        }
    }
    catch {
        Write-ColorOutput "PHP is not installed or not in PATH." "Red"
        Write-ColorOutput "Please install PHP $PHP_VERSION or higher: https://windows.php.net/download/" "Yellow"
        return $false
    }
}

# Check if Composer is installed
function Test-Composer {
    Write-ColorOutput "Checking if Composer is installed..." "Yellow"
    
    try {
        $composerVersion = composer --version
        if ($LASTEXITCODE -eq 0) {
            Write-ColorOutput "Composer is installed: $composerVersion" "Green"
            return $true
        } else {
            Write-ColorOutput "Composer is not installed or not working correctly." "Red"
            return $false
        }
    }
    catch {
        Write-ColorOutput "Composer is not installed or not in PATH." "Red"
        Write-ColorOutput "Please install Composer: https://getcomposer.org/download/" "Yellow"
        return $false
    }
}

# Check if Node.js is installed
function Test-Node {
    Write-ColorOutput "Checking if Node.js is installed..." "Yellow"
    
    try {
        $nodeVersion = node -v
        if ($LASTEXITCODE -eq 0) {
            Write-ColorOutput "Node.js is installed: $nodeVersion" "Green"
            
            # Check if version is compatible (remove v prefix and compare)
            $versionNumber = $nodeVersion.Substring(1)
            if ([int]$versionNumber.Split('.')[0] -lt [int]$NODE_VERSION) {
                Write-ColorOutput "Warning: Node.js version $versionNumber is lower than recommended version $NODE_VERSION." "Yellow"
                Write-ColorOutput "Some features may not work correctly." "Yellow"
            }
            
            return $true
        } else {
            Write-ColorOutput "Node.js is not installed or not working correctly." "Red"
            return $false
        }
    }
    catch {
        Write-ColorOutput "Node.js is not installed or not in PATH." "Red"
        Write-ColorOutput "Please install Node.js $NODE_VERSION or higher: https://nodejs.org/en/download/" "Yellow"
        return $false
    }
}

# Check if MySQL is installed
function Test-MySQL {
    Write-ColorOutput "Checking if MySQL is installed..." "Yellow"
    
    try {
        $mysqlVersion = mysql --version
        if ($LASTEXITCODE -eq 0) {
            Write-ColorOutput "MySQL is installed: $mysqlVersion" "Green"
            return $true
        } else {
            Write-ColorOutput "MySQL is not installed or not working correctly." "Red"
            return $false
        }
    }
    catch {
        Write-ColorOutput "MySQL is not installed or not in PATH." "Red"
        Write-ColorOutput "Please install MySQL: https://dev.mysql.com/downloads/installer/" "Yellow"
        return $false
    }
}

# Check if required ports are available
function Test-Ports {
    Write-ColorOutput "Checking if required ports are available..." "Yellow"
    
    $portsAvailable = $true
    
    # Check PHP server port
    try {
        $phpPortInUse = Get-NetTCPConnection -LocalPort $APP_PORT -ErrorAction SilentlyContinue
        if ($phpPortInUse) {
            Write-ColorOutput "Port $APP_PORT is already in use. PHP server will not be able to start." "Red"
            $portsAvailable = $false
        } else {
            Write-ColorOutput "Port $APP_PORT is available for PHP server." "Green"
        }
    }
    catch {
        Write-ColorOutput "Port $APP_PORT is available for PHP server." "Green"
    }
    
    # Check Vite server port
    try {
        $vitePortInUse = Get-NetTCPConnection -LocalPort $VITE_PORT -ErrorAction SilentlyContinue
        if ($vitePortInUse) {
            Write-ColorOutput "Port $VITE_PORT is already in use. Vite server will not be able to start." "Red"
            $portsAvailable = $false
        } else {
            Write-ColorOutput "Port $VITE_PORT is available for Vite server." "Green"
        }
    }
    catch {
        Write-ColorOutput "Port $VITE_PORT is available for Vite server." "Green"
    }
    
    # Check MySQL port
    try {
        $mysqlPortInUse = Get-NetTCPConnection -LocalPort $DB_PORT -ErrorAction SilentlyContinue
        if ($mysqlPortInUse) {
            Write-ColorOutput "Port $DB_PORT is already in use. This might be MySQL already running, which is fine." "Yellow"
        } else {
            Write-ColorOutput "Port $DB_PORT is available for MySQL server." "Green"
        }
    }
    catch {
        Write-ColorOutput "Port $DB_PORT is available for MySQL server." "Green"
    }
    
    return $portsAvailable
}

# Create or update .env file
function Update-EnvFile {
    Write-ColorOutput "Setting up environment..." "Yellow"
    
    if (Test-Path ".env") {
        Write-ColorOutput ".env file already exists." "Green"
    } else {
        if (Test-Path ".env.example") {
            Copy-Item ".env.example" ".env"
            Write-ColorOutput "Created .env file from .env.example" "Green"
        } else {
            Write-ColorOutput "No .env or .env.example file found. Creating a basic .env file..." "Yellow"
            
            $envContent = @"
APP_NAME=Liberty
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:$APP_PORT

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=$DB_PORT
DB_DATABASE=liberty
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

VITE_APP_PORT=$APP_PORT
VITE_PORT=$VITE_PORT
"@
            
            Set-Content -Path ".env" -Value $envContent
            Write-ColorOutput "Created basic .env file." "Green"
        }
    }
    
    # Update specific values in .env
    $envContent = Get-Content ".env"
    
    # Update APP_URL
    $envContent = $envContent -replace "APP_URL=.*", "APP_URL=http://localhost:$APP_PORT"
    
    # Update DB_PORT
    $envContent = $envContent -replace "DB_PORT=.*", "DB_PORT=$DB_PORT"
    
    # Update VITE_PORT
    $envContent = $envContent -replace "VITE_PORT=.*", "VITE_PORT=$VITE_PORT"
    
    # Add VITE_APP_PORT if it doesn't exist
    if (-not ($envContent -match "VITE_APP_PORT=")) {
        $envContent += "VITE_APP_PORT=$APP_PORT"
    } else {
        $envContent = $envContent -replace "VITE_APP_PORT=.*", "VITE_APP_PORT=$APP_PORT"
    }
    
    Set-Content -Path ".env" -Value $envContent
    Write-ColorOutput "Updated .env file with correct ports." "Green"
}

# Install Composer dependencies
function Install-Dependencies {
    Write-ColorOutput "Installing Composer dependencies..." "Yellow"
    
    composer install
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to install Composer dependencies." "Red"
        return $false
    }
    
    Write-ColorOutput "Composer dependencies installed successfully." "Green"
    return $true
}

# Generate application key
function Generate-AppKey {
    Write-ColorOutput "Generating application key..." "Yellow"
    
    php artisan key:generate
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to generate application key." "Red"
        return $false
    }
    
    Write-ColorOutput "Application key generated successfully." "Green"
    return $true
}

# Create database if it doesn't exist
function Create-Database {
    Write-ColorOutput "Setting up database..." "Yellow"
    
    # Get database name from .env
    $envContent = Get-Content ".env"
    $dbName = ($envContent | Select-String -Pattern "DB_DATABASE=(.*)").Matches.Groups[1].Value
    $dbUser = ($envContent | Select-String -Pattern "DB_USERNAME=(.*)").Matches.Groups[1].Value
    $dbPass = ($envContent | Select-String -Pattern "DB_PASSWORD=(.*)").Matches.Groups[1].Value
    
    if ([string]::IsNullOrEmpty($dbName)) {
        $dbName = "liberty"
    }
    
    Write-ColorOutput "Creating database '$dbName' if it doesn't exist..." "Yellow"
    
    # Create database using PHP artisan
    php artisan db:create
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to create database using artisan. Trying direct MySQL command..." "Yellow"
        
        # Try to create database using MySQL command
        if ([string]::IsNullOrEmpty($dbPass)) {
            mysql -u $dbUser -e "CREATE DATABASE IF NOT EXISTS $dbName;"
        } else {
            mysql -u $dbUser -p$dbPass -e "CREATE DATABASE IF NOT EXISTS $dbName;"
        }
        
        if ($LASTEXITCODE -ne 0) {
            Write-ColorOutput "Failed to create database. Please create it manually." "Red"
            Write-ColorOutput "MySQL command: CREATE DATABASE IF NOT EXISTS $dbName;" "Yellow"
            return $false
        }
    }
    
    Write-ColorOutput "Database setup completed." "Green"
    return $true
}

# Run database migrations
function Run-Migrations {
    Write-ColorOutput "Running database migrations..." "Yellow"
    
    php artisan migrate --force
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to run migrations." "Red"
        return $false
    }
    
    Write-ColorOutput "Database migrations completed successfully." "Green"
    return $true
}

# Install NPM dependencies
function Install-NpmDependencies {
    Write-ColorOutput "Installing NPM dependencies..." "Yellow"
    
    npm install
    if ($LASTEXITCODE -ne 0) {
        Write-ColorOutput "Failed to install NPM dependencies." "Red"
        return $false
    }
    
    Write-ColorOutput "NPM dependencies installed successfully." "Green"
    return $true
}

# Start PHP development server
function Start-PhpServer {
    Write-ColorOutput "Starting PHP development server on port $APP_PORT..." "Yellow"
    
    # Start PHP server in background
    Start-Process -FilePath "php" -ArgumentList "artisan serve --port=$APP_PORT" -NoNewWindow
    
    Write-ColorOutput "PHP server started at http://localhost:$APP_PORT" "Green"
}

# Start Vite development server
function Start-ViteServer {
    Write-ColorOutput "Starting Vite development server on port $VITE_PORT..." "Yellow"
    
    # Start Vite server in background
    Start-Process -FilePath "npm" -ArgumentList "run dev" -NoNewWindow
    
    Write-ColorOutput "Vite server started at http://localhost:$VITE_PORT" "Green"
}

# Main function
function Start-Liberty {
    Write-ColorOutput "🚀 Starting Liberty application without Docker..." "Cyan"
    
    # Check requirements
    $phpInstalled = Test-PHP
    $composerInstalled = Test-Composer
    $nodeInstalled = Test-Node
    $mysqlInstalled = Test-MySQL
    $portsAvailable = Test-Ports
    
    if (-not ($phpInstalled -and $composerInstalled -and $nodeInstalled -and $mysqlInstalled)) {
        Write-ColorOutput "Some required software is missing. Please install the missing components and try again." "Red"
        return
    }
    
    if (-not $portsAvailable) {
        Write-ColorOutput "Some required ports are already in use. Please free up these ports and try again." "Red"
        return
    }
    
    # Setup environment
    Update-EnvFile
    
    # Install dependencies
    $depsInstalled = Install-Dependencies
    if (-not $depsInstalled) {
        return
    }
    
    # Generate application key
    $keyGenerated = Generate-AppKey
    if (-not $keyGenerated) {
        return
    }
    
    # Setup database
    $dbCreated = Create-Database
    if (-not $dbCreated) {
        Write-ColorOutput "Warning: Database setup had issues, but we'll continue anyway." "Yellow"
    }
    
    # Run migrations
    $migrationsRun = Run-Migrations
    if (-not $migrationsRun) {
        Write-ColorOutput "Warning: Migrations had issues, but we'll continue anyway." "Yellow"
    }
    
    # Install NPM dependencies
    $npmInstalled = Install-NpmDependencies
    if (-not $npmInstalled) {
        Write-ColorOutput "Warning: NPM dependencies had issues, but we'll continue anyway." "Yellow"
    }
    
    # Start servers
    Start-PhpServer
    Start-ViteServer
    
    # Display success message
    Write-ColorOutput "🎉 Liberty application has been successfully started!" "Green"
    Write-ColorOutput "📱 You can access the application at: http://localhost:$APP_PORT" "Cyan"
    Write-ColorOutput "📱 Vite development server is running at: http://localhost:$VITE_PORT" "Cyan"
    Write-ColorOutput "" "White"
    Write-ColorOutput "Press Ctrl+C to stop the servers when you're done." "Yellow"
    
    # Keep the script running
    try {
        while ($true) {
            Start-Sleep -Seconds 1
        }
    }
    catch {
        Write-ColorOutput "Stopping servers..." "Yellow"
        # The script will exit naturally when Ctrl+C is pressed
    }
}

# Run the main function
Start-Liberty
