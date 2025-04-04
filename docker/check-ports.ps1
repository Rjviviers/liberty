# PowerShell script to check if required ports are available
# This script is used on Windows systems to check port availability

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
        Write-Host "Using default port configuration..."
    }

    # Display configured ports
    Write-Host "HTTP port: $script:HTTP_PORT"
    Write-Host "HTTPS port: $script:HTTPS_PORT"
    Write-Host "MySQL port: $script:MYSQL_PORT"
    Write-Host "Vite port: $script:VITE_PORT"
    Write-Host "PHP-FPM port: $script:PHP_PORT"
    Write-Host ""
}

# Check if a port is in use
function Test-PortInUse {
    param (
        [int]$Port,
        [string]$ServiceName
    )

    try {
        $inUse = Get-NetTCPConnection -LocalPort $Port -ErrorAction SilentlyContinue
        if ($inUse) {
            Write-Host "✗ Port $Port is already in use (required by $ServiceName)" -ForegroundColor Red
            return $true
        } else {
            Write-Host "✓ Port $Port is available for $ServiceName" -ForegroundColor Green
            return $false
        }
    } catch {
        Write-Host "✓ Port $Port is available for $ServiceName" -ForegroundColor Green
        return $false
    }
}

# Update ports.conf with new port values
function Update-PortConfig {
    param (
        [string]$PortName,
        [int]$OldPort,
        [int]$NewPort
    )

    $configFile = Join-Path -Path $PSScriptRoot -ChildPath "ports.conf"

    if (Test-Path $configFile) {
        $content = Get-Content $configFile
        $newContent = $content -replace "$PortName=$OldPort", "$PortName=$NewPort"
        $newContent | Set-Content $configFile
        Write-Host "Updated $PortName from $OldPort to $NewPort in ports.conf"
    } else {
        Write-Host "Port configuration file not found: $configFile" -ForegroundColor Red
    }
}

# Main function to check all required ports
function Check-AllPorts {
    Write-Host "Checking if required ports are available..." -ForegroundColor Yellow

    # Load port configuration
    Load-PortConfig

    $allPortsAvailable = $true

    # Check each required port
    if (Test-PortInUse -Port $script:HTTP_PORT -ServiceName "Nginx (HTTP)") { $allPortsAvailable = $false }
    if (Test-PortInUse -Port $script:HTTPS_PORT -ServiceName "Nginx (HTTPS)") { $allPortsAvailable = $false }
    if (Test-PortInUse -Port $script:MYSQL_PORT -ServiceName "MySQL") { $allPortsAvailable = $false }
    if (Test-PortInUse -Port $script:VITE_PORT -ServiceName "Vite dev server") { $allPortsAvailable = $false }
    if (Test-PortInUse -Port $script:PHP_PORT -ServiceName "PHP-FPM") { $allPortsAvailable = $false }

    Write-Host ""

    if ($allPortsAvailable) {
        Write-Host "All required ports are available." -ForegroundColor Green
        return $true
    } else {
        Write-Host "Some required ports are already in use." -ForegroundColor Red
        Write-Host "Please free up these ports before continuing or modify the docker-compose.yml file to use different ports."

        # Provide options to resolve port conflicts
        Write-Host "`nOptions to resolve port conflicts:" -ForegroundColor Yellow
        Write-Host "1. Automatically update ports in configuration"
        Write-Host "2. Manually edit docker-compose.yml"
        Write-Host "3. Continue anyway (not recommended)"
        Write-Host "4. Abort setup"

        $option = Read-Host "Select an option (1-4)"

        switch ($option) {
            "1" {
                # Automatically update ports
                Write-Host "Updating port configuration..." -ForegroundColor Yellow

                # For each conflicting port, suggest a new port
                if (Test-PortInUse -Port $script:HTTP_PORT -ServiceName "Nginx (HTTP)") {
                    $newHttpPort = 8080
                    while (Test-PortInUse -Port $newHttpPort -ServiceName "Nginx (HTTP)") {
                        $newHttpPort++
                    }
                    Update-PortConfig -PortName "HTTP_PORT" -OldPort $script:HTTP_PORT -NewPort $newHttpPort
                    $script:HTTP_PORT = $newHttpPort
                }

                if (Test-PortInUse -Port $script:HTTPS_PORT -ServiceName "Nginx (HTTPS)") {
                    $newHttpsPort = 8443
                    while (Test-PortInUse -Port $newHttpsPort -ServiceName "Nginx (HTTPS)") {
                        $newHttpsPort++
                    }
                    Update-PortConfig -PortName "HTTPS_PORT" -OldPort $script:HTTPS_PORT -NewPort $newHttpsPort
                    $script:HTTPS_PORT = $newHttpsPort
                }

                if (Test-PortInUse -Port $script:MYSQL_PORT -ServiceName "MySQL") {
                    $newMysqlPort = 33060
                    while (Test-PortInUse -Port $newMysqlPort -ServiceName "MySQL") {
                        $newMysqlPort++
                    }
                    Update-PortConfig -PortName "MYSQL_PORT" -OldPort $script:MYSQL_PORT -NewPort $newMysqlPort
                    $script:MYSQL_PORT = $newMysqlPort
                }

                if (Test-PortInUse -Port $script:VITE_PORT -ServiceName "Vite dev server") {
                    $newVitePort = 5174
                    while (Test-PortInUse -Port $newVitePort -ServiceName "Vite dev server") {
                        $newVitePort++
                    }
                    Update-PortConfig -PortName "VITE_PORT" -OldPort $script:VITE_PORT -NewPort $newVitePort
                    $script:VITE_PORT = $newVitePort
                }

                # Update docker-compose files with new ports
                $updateScript = Join-Path -Path $PSScriptRoot -ChildPath "update-ports.ps1"
                & powershell.exe -ExecutionPolicy Bypass -File $updateScript

                Write-Host "Port configuration updated. Continuing with setup..." -ForegroundColor Green
                return $true
            }
            "2" {
                # Manually edit docker-compose.yml
                Write-Host "`nTo modify ports in docker-compose.yml:" -ForegroundColor Yellow
                Write-Host "1. Open docker-compose.yml"
                Write-Host "2. Find the service with the conflicting port"
                Write-Host "3. Change the port mapping from ""80:80"" to something like ""8080:80"""
                Write-Host "4. Save the file and run the setup script again"
                Write-Host "Setup aborted. Please restart after making changes." -ForegroundColor Red
                return $false
            }
            "3" {
                # Continue anyway
                Write-Host "Continuing despite port conflicts..." -ForegroundColor Yellow
                Write-Host "Warning: Services may not start correctly due to port conflicts." -ForegroundColor Red
                return $true
            }
            default {
                # Abort setup
                Write-Host "Setup aborted." -ForegroundColor Red
                return $false
            }
        }
    }
}

# Run the port check if this script is executed directly
if ($MyInvocation.InvocationName -eq $MyInvocation.MyCommand.Name) {
    $result = Check-AllPorts
    if ($result) { exit 0 } else { exit 1 }
}
