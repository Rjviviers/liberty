### Running Without Docker

If you prefer to run the application directly on your Windows machine without Docker, we provide a simple script to set up and start the necessary services.

#### Prerequisites

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

#### Manual Setup

If you prefer to set up manually, follow these steps:

1. **Clone the repository:**

   ```bash
   git clone <repository-url>
   cd liberty
   ```

2. **Configure environment variables:**

   ```bash
   cp .env.example .env
   ```

   Edit the `.env` file to set your configuration:
   ```
   APP_URL=http://localhost:5412
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=liberty
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

3. **Install dependencies:**

   ```bash
   composer install
   npm install
   ```

4. **Generate application key:**

   ```bash
   php artisan key:generate
   ```

5. **Create database and run migrations:**

   ```bash
   php artisan db:create
   php artisan migrate
   ```

6. **Start the servers:**

   ```bash
   # In one terminal, start the PHP server
   php artisan serve --port=5412

   # In another terminal, start the Vite server
   npm run dev
   ```

7. **Access the application:**
   - Main application: [http://localhost:5412](http://localhost:5412)
   - Vite dev server: [http://localhost:5173](http://localhost:5173)
