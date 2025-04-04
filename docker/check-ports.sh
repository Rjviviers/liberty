#!/bin/bash

# Port checking script for Docker services
# This script checks if the required ports are available before starting Docker services

# Define colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
NC='\033[0m' # No Color

# Function to check if a port is in use
check_port() {
    local port=$1
    local service=$2

    # For Windows (using PowerShell)
    if [[ "$OSTYPE" == "msys" || "$OSTYPE" == "win32" ]]; then
        if powershell.exe -Command "Get-NetTCPConnection -LocalPort $port -ErrorAction SilentlyContinue" > /dev/null 2>&1; then
            echo -e "${RED}✗ Port $port is already in use (required by $service)${NC}"
            return 1
        else
            echo -e "${GREEN}✓ Port $port is available for $service${NC}"
            return 0
        fi
    # For Linux/Mac
    else
        if command -v nc &> /dev/null; then
            if nc -z localhost $port > /dev/null 2>&1; then
                echo -e "${RED}✗ Port $port is already in use (required by $service)${NC}"
                return 1
            else
                echo -e "${GREEN}✓ Port $port is available for $service${NC}"
                return 0
            fi
        elif command -v lsof &> /dev/null; then
            if lsof -i:$port > /dev/null 2>&1; then
                echo -e "${RED}✗ Port $port is already in use (required by $service)${NC}"
                return 1
            else
                echo -e "${GREEN}✓ Port $port is available for $service${NC}"
                return 0
            fi
        else
            echo -e "${YELLOW}! Cannot check if port $port is available. Please ensure it's not in use.${NC}"
            return 0
        fi
    fi
}

# Load port configuration if available
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
        echo -e "${YELLOW}Using default port configuration...${NC}"
    fi

    # Display configured ports
    echo -e "HTTP port: $HTTP_PORT"
    echo -e "HTTPS port: $HTTPS_PORT"
    echo -e "MySQL port: $MYSQL_PORT"
    echo -e "Vite port: $VITE_PORT"
    echo -e "PHP-FPM port: $PHP_PORT"
    echo ""
}

# Main function to check all required ports
check_all_ports() {
    echo -e "${YELLOW}Checking if required ports are available...${NC}"

    # Load port configuration
    load_port_config

    local all_ports_available=true

    # Check each required port
    check_port $HTTP_PORT "Nginx (HTTP)" || all_ports_available=false
    check_port $HTTPS_PORT "Nginx (HTTPS)" || all_ports_available=false
    check_port $MYSQL_PORT "MySQL" || all_ports_available=false
    check_port $VITE_PORT "Vite dev server" || all_ports_available=false
    check_port $PHP_PORT "PHP-FPM" || all_ports_available=false

    echo ""

    if [ "$all_ports_available" = true ]; then
        echo -e "${GREEN}All required ports are available.${NC}"
        return 0
    else
        echo -e "${RED}Some required ports are already in use.${NC}"
        echo -e "Please free up these ports before continuing or modify the docker-compose.yml file to use different ports."

        # Provide options to resolve port conflicts
        echo -e "\n${YELLOW}Options to resolve port conflicts:${NC}"
        echo -e "1. Automatically update ports in configuration"
        echo -e "2. Manually edit docker-compose.yml"
        echo -e "3. Continue anyway (not recommended)"
        echo -e "4. Abort setup"

        read -p "Select an option (1-4): " -n 1 -r
        echo ""

        case $REPLY in
            1)
                # Automatically update ports
                echo -e "${YELLOW}Updating port configuration...${NC}"

                # For each conflicting port, suggest a new port
                if ! check_port $HTTP_PORT "Nginx (HTTP)" > /dev/null 2>&1; then
                    local new_http_port=8080
                    while ! check_port $new_http_port "Nginx (HTTP)" > /dev/null 2>&1; do
                        ((new_http_port++))
                    done
                    echo -e "Changing HTTP port from $HTTP_PORT to $new_http_port"
                    sed -i "s/HTTP_PORT=$HTTP_PORT/HTTP_PORT=$new_http_port/" "$(dirname "$0")/ports.conf"
                fi

                if ! check_port $HTTPS_PORT "Nginx (HTTPS)" > /dev/null 2>&1; then
                    local new_https_port=8443
                    while ! check_port $new_https_port "Nginx (HTTPS)" > /dev/null 2>&1; do
                        ((new_https_port++))
                    done
                    echo -e "Changing HTTPS port from $HTTPS_PORT to $new_https_port"
                    sed -i "s/HTTPS_PORT=$HTTPS_PORT/HTTPS_PORT=$new_https_port/" "$(dirname "$0")/ports.conf"
                fi

                if ! check_port $MYSQL_PORT "MySQL" > /dev/null 2>&1; then
                    local new_mysql_port=33060
                    while ! check_port $new_mysql_port "MySQL" > /dev/null 2>&1; do
                        ((new_mysql_port++))
                    done
                    echo -e "Changing MySQL port from $MYSQL_PORT to $new_mysql_port"
                    sed -i "s/MYSQL_PORT=$MYSQL_PORT/MYSQL_PORT=$new_mysql_port/" "$(dirname "$0")/ports.conf"
                fi

                if ! check_port $VITE_PORT "Vite dev server" > /dev/null 2>&1; then
                    local new_vite_port=5174
                    while ! check_port $new_vite_port "Vite dev server" > /dev/null 2>&1; do
                        ((new_vite_port++))
                    done
                    echo -e "Changing Vite port from $VITE_PORT to $new_vite_port"
                    sed -i "s/VITE_PORT=$VITE_PORT/VITE_PORT=$new_vite_port/" "$(dirname "$0")/ports.conf"
                fi

                # Update docker-compose files with new ports
                chmod +x "$(dirname "$0")/update-ports.sh"
                "$(dirname "$0")/update-ports.sh"

                echo -e "${GREEN}Port configuration updated. Continuing with setup...${NC}"
                return 0
                ;;
            2)
                # Manually edit docker-compose.yml
                echo -e "\n${YELLOW}To modify ports in docker-compose.yml:${NC}"
                echo -e "1. Open docker-compose.yml"
                echo -e "2. Find the service with the conflicting port"
                echo -e "3. Change the port mapping from \"80:80\" to something like \"8080:80\""
                echo -e "4. Save the file and run the setup script again"
                echo -e "${RED}Setup aborted. Please restart after making changes.${NC}"
                return 1
                ;;
            3)
                # Continue anyway
                echo -e "${YELLOW}Continuing despite port conflicts...${NC}"
                echo -e "${RED}Warning: Services may not start correctly due to port conflicts.${NC}"
                return 0
                ;;
            *)
                # Abort setup
                echo -e "${RED}Setup aborted.${NC}"
                return 1
                ;;
        esac
    fi
}

# Run the port check if this script is executed directly
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    check_all_ports
    exit $?
fi
