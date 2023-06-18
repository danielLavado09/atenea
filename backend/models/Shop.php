<?php
require_once '../database/db.php';

class Shop
{
    private $connection;

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    public function getShopsByPage($page, $limit)
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM tienda LIMIT $offset, $limit";
        $result = $this->connection->query($query);

        $shops = array();
        while ($row = $result->fetch_assoc()) {
            $shops[] = $row;
        }

        return $shops;
    }

    public function getTotalPages($limit)
    {
        $query = "SELECT COUNT(*) as total FROM tienda";
        $result = $this->connection->query($query);
        $row = $result->fetch_assoc();

        $totalRows = $row['total'];
        $totalPages = ceil($totalRows / $limit);

        return $totalPages;
    }

    public function createShop($nombre, $fechaApertura)
    {
        $query = "INSERT INTO tienda (nombre, fecha_apertura) VALUES ('$nombre', '$fechaApertura')";
        $this->connection->query($query);
    }

    public function getShop($id)
    {
        $query = "SELECT * FROM tienda WHERE id = $id";
        $result = $this->connection->query($query);
        return $result->fetch_assoc();
    }

    public function updateShop($id, $nombre, $fechaApertura)
    {
        $query = "UPDATE tienda SET nombre = '$nombre', fecha_apertura = '$fechaApertura' WHERE id = $id";
        $this->connection->query($query);
    }

    public function deleteShop($id)
    {
        $query = "DELETE FROM tienda WHERE id = $id";
        $this->connection->query($query);
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}
