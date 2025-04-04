#!/bin/bash

# Update Docker Compose ports script
# This script updates the docker-compose.yml file with custom port configurations

# Define colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
NC='\033[0m' # No Color

# Load port configuration
load_port_config() {
    local config_file="$(dirname "$0")/ports.conf"
    
    # Default values
    HTTP_PORT=80
    HTTPS_PORT=443
    MYSQL_PORT=3306
    VITE_PORT=5173
    PHP_PORT=9000
    
    # Load from config file if it exists
    if [ -f "$config_file" ]; then
        echo -e "${YELLOW}Loading port configuration from $config_file...${NC}"
        source "$config_file"
    else
        echo -e "${RED}Port configuration file not found: $config_file${NC}"
        exit 1
    fi
}

# Update docker-compose.yml file
update_docker_compose() {
    local compose_file="$1"
    local temp_file="${compose_file}.tmp"
    
    echo -e "${YELLOW}Updating port configuration in $compose_file...${NC}"
    
    # Check if the file exists
    if [ ! -f "$compose_file" ]; then
        echo -e "${RED}Docker Compose file not found: $compose_file${NC}"
        exit 1
    fi
    
    # Create a backup
    cp "$compose_file" "${compose_file}.bak"
    echo -e "Created backup: ${compose_file}.bak"
    
    # Update HTTP port
    sed -E "s/\"([0-9]+):80\"/\"$HTTP_PORT:80\"/" "$compose_file" > "$temp_file"
    mv "$temp_file" "$compose_file"
    
    # Update HTTPS port (if present)
    if grep -q "\"[0-9]\+:443\"" "$compose_file"; then
        sed -E "s/\"([0-9]+):443\"/\"$HTTPS_PORT:443\"/" "$compose_file" > "$temp_file"
        mv "$temp_file" "$compose_file"
    fi
    
    # Update MySQL port
    sed -E "s/\"([0-9]+):3306\"/\"$MYSQL_PORT:3306\"/" "$compose_file" > "$temp_file"
    mv "$temp_file" "$compose_file"
    
    # Update Vite port
    sed -E "s/\"([0-9]+):5173\"/\"$VITE_PORT:5173\"/" "$compose_file" > "$temp_file"
    mv "$temp_file" "$compose_file"
    
    # Update environment variables for Vite
    if grep -q "VITE_PORT" "$compose_file"; then
        sed -E "s/VITE_PORT=([0-9]+)/VITE_PORT=$VITE_PORT/" "$compose_file" > "$temp_file"
        mv "$temp_file" "$compose_file"
    fi
    
    echo -e "${GREEN}Port configuration updated successfully in $compose_file${NC}"
    echo -e "HTTP port: $HTTP_PORT"
    echo -e "HTTPS port: $HTTPS_PORT"
    echo -e "MySQL port: $MYSQL_PORT"
    echo -e "Vite port: $VITE_PORT"
}

# Main function
main() {
    # Load port configuration
    load_port_config
    
    # Update docker-compose.yml
    update_docker_compose "$(dirname "$0")/../docker-compose.yml"
    
    # Update docker-compose.prod.yml if it exists
    if [ -f "$(dirname "$0")/../docker-compose.prod.yml" ]; then
        update_docker_compose "$(dirname "$0")/../docker-compose.prod.yml"
    fi
    
    echo -e "\n${GREEN}All Docker Compose files have been updated with the new port configuration.${NC}"
    echo -e "You can now run the setup script to start the containers with the new ports."
}

# Run the main function if this script is executed directly
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main
    exit $?
fi
