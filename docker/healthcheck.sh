#!/bin/bash

# Health check script for Docker containers
# This script checks if all required Docker containers are running properly

# Define colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
NC='\033[0m' # No Color

# Define containers to check
CONTAINERS=("liberty-app" "liberty-webserver" "liberty-db" "liberty-node")

echo -e "${YELLOW}Checking Docker container health...${NC}"
echo ""

ALL_HEALTHY=true

for CONTAINER in "${CONTAINERS[@]}"; do
    # Check if container exists and is running
    if [ "$(docker ps -q -f name=$CONTAINER)" ]; then
        STATUS=$(docker inspect --format='{{.State.Status}}' $CONTAINER)
        if [ "$STATUS" == "running" ]; then
            # For containers with health checks
            if docker inspect --format='{{if .State.Health}}{{.State.Health.Status}}{{else}}no-healthcheck{{end}}' $CONTAINER | grep -q "healthy"; then
                echo -e "${GREEN}✓ $CONTAINER is running and healthy${NC}"
            elif docker inspect --format='{{if .State.Health}}{{.State.Health.Status}}{{else}}no-healthcheck{{end}}' $CONTAINER | grep -q "no-healthcheck"; then
                echo -e "${GREEN}✓ $CONTAINER is running (no health check)${NC}"
            else
                HEALTH_STATUS=$(docker inspect --format='{{.State.Health.Status}}' $CONTAINER)
                echo -e "${RED}✗ $CONTAINER is running but health check status is: $HEALTH_STATUS${NC}"
                ALL_HEALTHY=false
            fi
        else
            echo -e "${RED}✗ $CONTAINER exists but is not running (status: $STATUS)${NC}"
            ALL_HEALTHY=false
        fi
    else
        echo -e "${RED}✗ $CONTAINER does not exist or is not running${NC}"
        ALL_HEALTHY=false
    fi
done

echo ""
if [ "$ALL_HEALTHY" = true ]; then
    echo -e "${GREEN}All containers are running properly!${NC}"
    exit 0
else
    echo -e "${RED}Some containers have issues. Check the logs for more details:${NC}"
    echo "docker-compose logs"
    exit 1
fi
