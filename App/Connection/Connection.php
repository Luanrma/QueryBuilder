<?php

namespace App\Connection;

use PDO;
use PDOException;

class Connection {
    private $dbHostname = "localhost";
    private $dbName = "vhsys";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->dbHostname; dbname=$this->dbName", $this->dbUsername, $this->dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
              echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}