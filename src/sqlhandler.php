<?php

require_once 'utils.php';
disallowDirectAccess(__FILE__);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'env.php';


class SQLConnection
{
    private $conn;
    public function __construct()
    {
        global $db_host, $db_port, $db_user, $db_pass, $db_database;
        $this->conn = new PDO(
            "mysql:host=$db_host;port=$db_port;dbname=$db_database;charset=utf8",
            $db_user,
            $db_pass
        );
    }
    public function destroy()
    {
        $this->conn = null;

    }

    public function getWithSql(string $query = "", array|null $params = null): array
    {
        $pointer = $this->execute($query, $params);
        if ($pointer === false) {
            return [];
        }
        return $pointer->fetchAll();
    }

    public function executeWithSql(string $query = "", array|null $params = null): void
    {
        $this->execute($query, $params);
    }

    private function execute(string $query = "", array|null $params = null): bool|PDOStatement
    {
        if (empty($query)) {
            return false;
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

}