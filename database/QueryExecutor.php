<?php

namespace App\Database;
class QueryExecutor
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function executeQuery(string $query, array $params = []): array
    {
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);

            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit("Query execution failed: {$e->getMessage()}");
        }
    }
}