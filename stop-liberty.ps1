# Liberty Application Stop Script for Windows
# This script stops the Liberty application servers

# Define colors for output
function Write-ColorOutput {
    param (
        [string]$Text,
        [string]$Color = "White"
    )
    
    Write-Host $Text -ForegroundColor $Color
}

# Stop PHP server
function Stop-PhpServer {
    Write-ColorOutput "Stopping PHP development server..." "Yellow"
    
    $phpProcesses = Get-Process -Name "php" -ErrorAction SilentlyContinue | Where-Object { $_.CommandLine -like "*artisan serve*" }
    
    if ($phpProcesses) {
        foreach ($process in $phpProcesses) {
            Stop-Process -Id $process.Id -Force
        }
        Write-ColorOutput "PHP server stopped." "Green"
    } else {
        Write-ColorOutput "No PHP server processes found." "Yellow"
    }
}

# Stop Node/Vite server
function Stop-NodeServer {
    Write-ColorOutput "Stopping Node/Vite development server..." "Yellow"
    
    $nodeProcesses = Get-Process -Name "node" -ErrorAction SilentlyContinue | Where-Object { $_.CommandLine -like "*vite*" }
    
    if ($nodeProcesses) {
        foreach ($process in $nodeProcesses) {
            Stop-Process -Id $process.Id -Force
        }
        Write-ColorOutput "Node/Vite server stopped." "Green"
    } else {
        Write-ColorOutput "No Node/Vite server processes found." "Yellow"
    }
}

# Main function
function Stop-Liberty {
    Write-ColorOutput "🛑 Stopping Liberty application servers..." "Cyan"
    
    # Stop servers
    Stop-PhpServer
    Stop-NodeServer
    
    # Display success message
    Write-ColorOutput "✅ All Liberty application servers have been stopped." "Green"
}

# Run the main function
Stop-Liberty
