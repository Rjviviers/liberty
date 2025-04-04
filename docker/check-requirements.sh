#!/bin/bash

# Check if all requirements for Docker installation are met

# Define colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Checking system requirements for Docker installation...${NC}"
echo ""

# Check if Docker is installed
if command -v docker &> /dev/null; then
    DOCKER_VERSION=$(docker --version)
    echo -e "${GREEN}✓ Docker is installed: $DOCKER_VERSION${NC}"
else
    echo -e "${RED}✗ Docker is not installed${NC}"
    echo "Please install Docker: https://docs.docker.com/get-docker/"
    exit 1
fi

# Check if Docker Compose is installed
if command -v docker-compose &> /dev/null; then
    COMPOSE_VERSION=$(docker-compose --version)
    echo -e "${GREEN}✓ Docker Compose is installed: $COMPOSE_VERSION${NC}"
else
    echo -e "${RED}✗ Docker Compose is not installed${NC}"
    echo "Please install Docker Compose: https://docs.docker.com/compose/install/"
    exit 1
fi

# Check if Docker daemon is running
if docker info &> /dev/null; then
    echo -e "${GREEN}✓ Docker daemon is running${NC}"
else
    echo -e "${RED}✗ Docker daemon is not running${NC}"
    echo "Please start Docker daemon"
    exit 1
fi

# Check available disk space
AVAILABLE_SPACE=$(df -h . | awk 'NR==2 {print $4}')
echo -e "${GREEN}✓ Available disk space: $AVAILABLE_SPACE${NC}"

# Check if ports 80 and 3306 are available
if ! netstat -tuln 2>/dev/null | grep -q ":80 "; then
    echo -e "${GREEN}✓ Port 80 is available${NC}"
else
    echo -e "${RED}✗ Port 80 is already in use${NC}"
    echo "Please free up port 80 or modify the docker-compose.yml file to use a different port"
fi

if ! netstat -tuln 2>/dev/null | grep -q ":3306 "; then
    echo -e "${GREEN}✓ Port 3306 is available${NC}"
else
    echo -e "${YELLOW}⚠ Port 3306 is already in use${NC}"
    echo "This might conflict with the MySQL container. Consider stopping your local MySQL service or changing the port in docker-compose.yml"
fi

if ! netstat -tuln 2>/dev/null | grep -q ":5173 "; then
    echo -e "${GREEN}✓ Port 5173 is available${NC}"
else
    echo -e "${YELLOW}⚠ Port 5173 is already in use${NC}"
    echo "This might conflict with the Vite dev server. Consider changing the port in docker-compose.yml"
fi

echo ""
echo -e "${GREEN}System check completed. You're ready to install Liberty with Docker!${NC}"
echo "Run ./setup.sh to start the installation process."
