<?php

namespace App\Database;
use PDO;
class Database
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        $this->connect($config);
    }

    private function connect(array $config): void
    {
        $driver = $config['driver'];
        $host = $config['host'];
        $port = $config['port'];
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];
        $charset = $config['charset'];

        try {
            $this->pdo = new PDO(
                "$driver:host=$host;port=$port;dbname=$database;charset=$charset",
                $username,
                $password
            );
        } catch (\PDOException $e){
            exit("Database connection failed: {$e->getMessage()}");
        }
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}