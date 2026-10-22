<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private string $host = "localhost";
    private string $dbName = "finanzas_db";
    private string $username = "root";
    private string $password = "";
    private ?PDO $conn = null;

    public function getConnection(): PDO {
        if ($this->conn === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false, // Mayor seguridad contra inyecciones SQL
                ];
                $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            } catch (PDOException $e) {
                throw new \RuntimeException("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}