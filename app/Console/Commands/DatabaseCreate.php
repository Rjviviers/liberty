<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;
use PDOException;

class DatabaseCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the database defined in the .env file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = env('DB_DATABASE', false);

        if (!$database) {
            $this->error('Database name not found in .env file');
            return;
        }

        $host = env('DB_HOST', 'localhost');
        $port = env('DB_PORT', '3306');
        $username = env('DB_USERNAME', 'root');
        $password = env('DB_PASSWORD', '');

        try {
            $pdo = new PDO(
                "mysql:host=$host;port=$port",
                $username,
                $password
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if database exists
            $statement = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'");
            $exists = $statement->fetchColumn();

            if ($exists) {
                $this->info("Database '$database' already exists");
                return;
            }

            // Create database
            $pdo->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->info("Database '$database' created successfully");
        } catch (PDOException $e) {
            $this->error("Failed to create database: " . $e->getMessage());
        }
    }
}
