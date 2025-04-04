# PowerShell script to update Docker Compose ports
# This script updates the docker-compose.yml file with custom port configurations

# Load port configuration
function Load-PortConfig {
    $configFile = Join-Path -Path $PSScriptRoot -ChildPath "ports.conf"
    
    # Default values
    $script:HTTP_PORT = 80
    $script:HTTPS_PORT = 443
    $script:MYSQL_PORT = 3306
    $script:VITE_PORT = 5173
    $script:PHP_PORT = 9000
    
    # Load from config file if it exists
    if (Test-Path $configFile) {
        Write-Host "Loading port configuration from $configFile..."
        
        Get-Content $configFile | ForEach-Object {
            if ($_ -match "^([A-Z_]+)=(\d+)$") {
                $varName = $matches[1]
                $varValue = $matches[2]
                
                switch ($varName) {
                    "HTTP_PORT" { $script:HTTP_PORT = $varValue }
                    "HTTPS_PORT" { $script:HTTPS_PORT = $varValue }
                    "MYSQL_PORT" { $script:MYSQL_PORT = $varValue }
                    "VITE_PORT" { $script:VITE_PORT = $varValue }
                    "PHP_PORT" { $script:PHP_PORT = $varValue }
                }
            }
        }
    } else {
        Write-Host "Port configuration file not found: $configFile" -ForegroundColor Red
        exit 1
    }
}

# Update docker-compose.yml file
function Update-DockerCompose {
    param (
        [string]$ComposeFile
    )
    
    Write-Host "Updating port configuration in $ComposeFile..." -ForegroundColor Yellow
    
    # Check if the file exists
    if (-not (Test-Path $ComposeFile)) {
        Write-Host "Docker Compose file not found: $ComposeFile" -ForegroundColor Red
        return
    }
    
    # Create a backup
    Copy-Item $ComposeFile "$ComposeFile.bak"
    Write-Host "Created backup: $ComposeFile.bak"
    
    # Read the file content
    $content = Get-Content $ComposeFile -Raw
    
    # Update HTTP port
    $content = $content -replace "\"(\d+):80\"", "\"$script:HTTP_PORT`:80\""
    
    # Update HTTPS port (if present)
    if ($content -match "\"(\d+):443\"") {
        $content = $content -replace "\"(\d+):443\"", "\"$script:HTTPS_PORT`:443\""
    }
    
    # Update MySQL port
    $content = $content -replace "\"(\d+):3306\"", "\"$script:MYSQL_PORT`:3306\""
    
    # Update Vite port
    $content = $content -replace "\"(\d+):5173\"", "\"$script:VITE_PORT`:5173\""
    
    # Update environment variables for Vite
    if ($content -match "VITE_PORT=(\d+)") {
        $content = $content -replace "VITE_PORT=(\d+)", "VITE_PORT=$script:VITE_PORT"
    }
    
    # Write the updated content back to the file
    $content | Set-Content $ComposeFile
    
    Write-Host "Port configuration updated successfully in $ComposeFile" -ForegroundColor Green
    Write-Host "HTTP port: $script:HTTP_PORT"
    Write-Host "HTTPS port: $script:HTTPS_PORT"
    Write-Host "MySQL port: $script:MYSQL_PORT"
    Write-Host "Vite port: $script:VITE_PORT"
}

# Main function
function Main {
    # Load port configuration
    Load-PortConfig
    
    # Update docker-compose.yml
    $rootDir = Split-Path -Parent $PSScriptRoot
    Update-DockerCompose "$rootDir\docker-compose.yml"
    
    # Update docker-compose.prod.yml if it exists
    if (Test-Path "$rootDir\docker-compose.prod.yml") {
        Update-DockerCompose "$rootDir\docker-compose.prod.yml"
    }
    
    Write-Host "`nAll Docker Compose files have been updated with the new port configuration." -ForegroundColor Green
    Write-Host "You can now run the setup script to start the containers with the new ports."
}

# Run the main function if this script is executed directly
if ($MyInvocation.InvocationName -eq $MyInvocation.MyCommand.Name) {
    Main
}
