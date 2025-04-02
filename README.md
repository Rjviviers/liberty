# Liberty - Laravel & Vue.js Application

## Docker Deployment Instructions

This application is configured for easy deployment using Docker. Follow these steps to get started:

### Prerequisites

- Docker and Docker Compose installed on your machine
- Git (to clone the repository)

### Setup Instructions

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd liberty
   ```

2. **Configure environment variables:**
   ```bash
   cp .env.docker .env
   ```
   - Edit the `.env` file to set your desired configuration (database credentials, app name, etc.)

3. **Start the Docker containers:**
   ```bash
   docker-compose up -d
   ```

4. **Install dependencies and set up the application:**
   ```bash
   # Access the app container
   docker exec -it liberty-app bash
   
   # Inside the container:
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   
   # If you want to seed the database with sample data:
   php artisan db:seed
   ```

5. **Install frontend dependencies and build assets:**
   ```bash
   # The node service should automatically handle this when starting the containers
   # If you need to manually run commands:
   docker exec -it liberty-node sh -c "npm install && npm run build"
   ```

6. **Access the application:**
   - Frontend: http://localhost
   - Vite dev server: http://localhost:5173 (only in development mode)

### Common Docker Commands

- Start containers: `docker-compose up -d`
- Stop containers: `docker-compose down`
- View container logs: `docker-compose logs -f`
- Rebuild containers: `docker-compose up -d --build`
- Execute commands in containers:
  - PHP/Laravel: `docker exec -it liberty-app <command>`
  - Node: `docker exec -it liberty-node <command>`

### Production Deployment Considerations

For production deployments, consider the following:

1. Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
2. Use a proper domain with SSL (configure Nginx accordingly)
3. Set strong database passwords
4. Run `npm run build` instead of `npm run dev` for frontend assets
5. Consider using a reverse proxy like Traefik for easier SSL management and routing

## Development

For local development without Docker, refer to the standard Laravel development procedures in the Laravel documentation.

## License

[License information] 