# Liberty - Laravel & Vue.js Application

## Deployment Instructions

You can deploy this application either using Docker or directly on your machine without Docker.

### Docker Deployment

This application is configured for easy deployment using Docker. Follow these steps to get started:

#### Prerequisites

- Docker and Docker Compose installed on your machine
- Git (to clone the repository)

### Quick Setup (Automated)

For the easiest setup experience, use our automated setup script:

```bash
# On Linux/Mac:
chmod +x setup.sh
./setup.sh

# On Windows with WSL/Git Bash:
# Make sure the script is executable and run:
bash setup.sh

# On Windows without WSL (using PowerShell):
# Double-click setup-windows.bat or run:
.\setup-windows.bat
```

This script will:

1. Create the necessary environment file
2. Create required directories with proper permissions
3. Start Docker containers
4. Install all dependencies
5. Set up the database
6. Build frontend assets

### Manual Setup Instructions

If you prefer to set up manually, follow these steps:

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

3. **Create necessary directories:**
   ```bash
   mkdir -p storage/app/public
   mkdir -p storage/framework/cache
   mkdir -p storage/framework/sessions
   mkdir -p storage/framework/views
   mkdir -p storage/logs
   chmod -R 775 storage bootstrap/cache
   ```

4. **Start the Docker containers:**
   ```bash
   docker-compose up -d
   ```

5. **Install dependencies and set up the application:**
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

6. **Install frontend dependencies and build assets:**
   ```bash
   # The node service should automatically handle this when starting the containers
   # If you need to manually run commands:
   docker exec -it liberty-node sh -c "npm install && npm run build"
   ```

7. **Access the application:**
   - Frontend: [http://localhost](http://localhost)
   - Vite dev server: [http://localhost:5173](http://localhost:5173) (only in development mode)

### Windows-Specific Setup

For Windows users without WSL, we provide a dedicated Windows setup:

1. **Prerequisites**:
   - Install [Docker Desktop for Windows](https://www.docker.com/products/docker-desktop/)
   - Make sure Docker Desktop is running before starting the setup

2. **Quick Setup**:
   - Double-click `setup-windows.bat` or run it from PowerShell
   - The script will automatically configure everything for Windows

3. **Manual Commands** (using PowerShell):
   ```powershell
   # Start containers
   .\docker-compose-windows.bat up -d

   # Stop containers
   .\docker-compose-windows.bat down

   # View logs
   .\docker-compose-windows.bat logs

   # Execute commands in containers
   .\docker-compose-windows.bat exec app php artisan migrate
   ```

4. **Troubleshooting**:
   - If you encounter permission issues, make sure Docker Desktop has access to your drive
   - For file sharing issues, check Docker Desktop settings → Resources → File sharing
   - For performance issues, adjust memory allocation in Docker Desktop settings

### Port Configuration

By default, the application uses the following ports:

- HTTP: 80 (Nginx)
- HTTPS: 443 (Nginx, for production)
- MySQL: 3306
- Vite dev server: 5173
- PHP-FPM: 9000 (internal)

If any of these ports are already in use on your system, the setup script will detect this and offer options to:

1. **Automatically update ports** - The script will find available ports and update the configuration
2. **Manually edit configuration** - You can edit the ports yourself
3. **Continue anyway** - Not recommended as services may fail to start
4. **Abort setup** - Cancel the installation

To manually change ports before installation:

```bash
# On Linux/Mac/WSL:
# Edit the port configuration file
nano docker/ports.conf

# Update Docker Compose files with the new ports
bash docker/update-ports.sh

# Then run the setup script
bash setup.sh
```

```powershell
# On Windows (PowerShell):
# Edit the port configuration file
notepad docker\ports.conf

# Update Docker Compose files with the new ports
powershell -ExecutionPolicy Bypass -File .\docker\update-ports.ps1

# Then run the setup script
.\setup-windows.bat
```

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

### Running Without Docker

If you prefer to run the application directly on your Windows machine without Docker, we provide a simple script to set up and start the necessary services.

#### Non-Docker Prerequisites

- PHP 8.2 or higher installed and in your PATH
- Composer installed and in your PATH
- Node.js 20 or higher installed and in your PATH
- MySQL installed and running
- Git (to clone the repository)

#### Quick Start

1. **Start the application:**

   Simply double-click the `start-liberty.bat` file or run:

   ```powershell
   .\start-liberty.bat
   ```

   This script will:
   - Check for required software
   - Set up the environment
   - Install dependencies
   - Create the database if needed
   - Run migrations
   - Start the PHP development server on port 5412
   - Start the Vite development server for frontend assets

2. **Access the application:**

   Once the script completes, you can access the application at:
   - Main application: [http://localhost:5412](http://localhost:5412)
   - Vite dev server: [http://localhost:5173](http://localhost:5173)

3. **Stop the application:**

   When you're done, you can stop the servers by:
   - Pressing Ctrl+C in the terminal window
   - Or running the stop script:

   ```powershell
   .\stop-liberty.bat
   ```

## License

[License information]
