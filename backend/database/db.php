<?php
class Database
{
    private $connection;

    public function __construct()
    {
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = '';

        $this->connection = new mysqli($host, $username, $password, $database);
        if ($this->connection->connect_error) {
            die('Error de conexión: ' . $this->connection->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
