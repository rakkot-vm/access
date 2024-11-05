<?php

declare(strict_types=1);

namespace App\Db;

use PDO;
use Dotenv\Dotenv;

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->pdo = new PDO(
            "mysql:host={$_ENV['MYSQL_HOST']};dbname={$_ENV['MYSQL_DATABASE']}",
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD']
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
