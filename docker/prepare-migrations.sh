#!/bin/bash

# Migration Preparation Script
# This script prepares the database and migrations for a successful first run

# Define colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Preparing database for migrations...${NC}"

# Check if database exists and is accessible
echo -e "Checking database connection..."
if php artisan db:show --database=mysql > /dev/null 2>&1; then
    echo -e "${GREEN}✓ Database connection successful${NC}"
else
    echo -e "${RED}✗ Database connection failed${NC}"
    echo -e "Waiting for database to be ready..."
    # Wait for database to be ready (up to 30 seconds)
    for i in {1..30}; do
        if php artisan db:show --database=mysql > /dev/null 2>&1; then
            echo -e "${GREEN}✓ Database connection successful${NC}"
            break
        fi
        echo -n "."
        sleep 1
        if [ $i -eq 30 ]; then
            echo -e "${RED}✗ Database connection timed out${NC}"
            echo -e "Please check your database configuration and ensure the database server is running."
            exit 1
        fi
    done
fi

# Fix migration file timestamps to ensure proper order
echo -e "\nChecking migration file timestamps..."
php /var/www/docker/fix-migrations.php

# Create database if it doesn't exist
echo -e "\nEnsuring database exists..."
DB_NAME=$(grep DB_DATABASE= .env | cut -d '=' -f2)
if [ -z "$DB_NAME" ]; then
    echo -e "${RED}✗ DB_DATABASE not found in .env file${NC}"
    exit 1
fi

echo -e "Using database: $DB_NAME"

# Check if migrations table exists
echo -e "\nChecking migrations table..."
if php artisan db:table migrations > /dev/null 2>&1; then
    echo -e "${GREEN}✓ Migrations table exists${NC}"
else
    echo -e "${YELLOW}! Migrations table does not exist, will be created during migration${NC}"
fi

echo -e "\n${GREEN}Database preparation complete. Ready to run migrations.${NC}"
