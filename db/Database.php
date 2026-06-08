<?php
class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "admin";
    private $dbname = "tp_backend";

    private function connect()
    {
        return new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->dbname, $this->username, $this->password);
    }

    public function fetchQuery($sql, $params = [])
    {
        try {
            $pdo = $this->connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'status' => 'success',
                'data' => $results
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'data' => $e->getMessage()
            ];
        }
    }

    public function executeQuery($sql, $params = [])
    {
        try {
            $pdo = $this->connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $lastID = $pdo->lastInsertId();
            $affectedRows = $stmt->rowCount();

            return [
                'status' => 'success',
                'lastID' => $lastID,
                'affectedRows' => $affectedRows
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'data' => $e->getMessage()
            ];
        }
    }
}
