#!/bin/bash

# Migration Test Script
# This script tests if migrations will run successfully in a clean environment

# Define colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Testing migrations in a clean environment...${NC}"

# Create a temporary database for testing
TEST_DB="liberty_test_$(date +%s)"
echo -e "Creating temporary test database: $TEST_DB"

# Get database credentials from .env
DB_HOST=$(grep DB_HOST= .env | cut -d '=' -f2)
DB_PORT=$(grep DB_PORT= .env | cut -d '=' -f2)
DB_USERNAME=$(grep DB_USERNAME= .env | cut -d '=' -f2)
DB_PASSWORD=$(grep DB_PASSWORD= .env | cut -d '=' -f2)

# Create test database
echo -e "Creating test database..."
mysql -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD -e "CREATE DATABASE IF NOT EXISTS $TEST_DB;"

if [ $? -ne 0 ]; then
    echo -e "${RED}Failed to create test database. Check your database credentials.${NC}"
    exit 1
fi

# Create temporary .env file for testing
cp .env .env.migration-test
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$TEST_DB/" .env.migration-test

# Run migration preparation script
echo -e "\nPreparing migrations..."
chmod +x /var/www/docker/prepare-migrations.sh
DB_DATABASE=$TEST_DB /var/www/docker/prepare-migrations.sh

# Run migrations with pretend flag first to check for issues
echo -e "\nChecking migrations (dry run)..."
php artisan migrate --pretend --env=migration-test

if [ $? -ne 0 ]; then
    echo -e "${RED}Migration check failed. There are issues with your migrations.${NC}"
    # Clean up
    mysql -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD -e "DROP DATABASE IF EXISTS $TEST_DB;"
    rm .env.migration-test
    exit 1
fi

# Run actual migrations
echo -e "\nRunning migrations on test database..."
php artisan migrate --env=migration-test --force

if [ $? -ne 0 ]; then
    echo -e "${RED}Migration failed. There are issues with your migrations.${NC}"
    # Clean up
    mysql -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD -e "DROP DATABASE IF EXISTS $TEST_DB;"
    rm .env.migration-test
    exit 1
fi

echo -e "${GREEN}Migrations completed successfully!${NC}"

# Clean up
echo -e "\nCleaning up test environment..."
mysql -h $DB_HOST -P $DB_PORT -u $DB_USERNAME -p$DB_PASSWORD -e "DROP DATABASE IF EXISTS $TEST_DB;"
rm .env.migration-test

echo -e "${GREEN}Migration test completed successfully. Your migrations should work on first run.${NC}"
