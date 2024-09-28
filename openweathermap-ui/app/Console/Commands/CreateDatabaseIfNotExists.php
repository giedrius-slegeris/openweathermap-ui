<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDatabaseIfNotExists extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Create the database if it does not exist';

    public function handle()
    {
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");
        $charset = config("database.connections.{$connection}.charset", 'utf8mb4');
        $collation = config("database.connections.{$connection}.collation", 'utf8mb4_unicode_ci');

        $this->info("Checking if database '{$database}' exists...");

        try {
            $pdo = $this->getPdoConnection($connection);

            // Check if the database exists
            $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$database}'");
            
            if (!$stmt->fetch()) {
                $this->info("Database '{$database}' does not exist. Creating...");
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET `{$charset}` COLLATE `{$collation}`;");
                $this->info("Database '{$database}' created successfully.");
            } else {
                $this->info("Database '{$database}' already exists.");
            }
        } catch (\Exception $e) {
            $this->error("An error occurred while creating the DB: " . $e->getMessage());
        }
    }

    private function getPdoConnection($connection)
    {
        $host = config("database.connections.{$connection}.host");
        $port = config("database.connections.{$connection}.port");
        $username = config("database.connections.{$connection}.username");
        $password = config("database.connections.{$connection}.password");

        return new \PDO(
            "mysql:host={$host};port={$port}",
            $username,
            $password
        );
    }
}
