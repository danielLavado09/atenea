<?php
require_once '../database/db.php';

class Product
{
    private $connection;

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    public function getProductsByPage($page, $limit, $shopId)
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT p.nombre, p.sku, p.descripcion, p.valor, t.nombre AS nombre_tienda, p.imagen
        FROM producto p
        JOIN tienda t ON p.tienda = t.id
        WHERE p.tienda = $shopId
        LIMIT $offset, $limit";
        $result = $this->connection->query($query);

        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    public function getTotalPages($limit, $shopId)
    {
        $query = "SELECT COUNT(*) as total
        FROM producto p
        JOIN tienda t ON p.tienda = t.id
        WHERE p.tienda = $shopId";
        $result = $this->connection->query($query);
        $row = $result->fetch_assoc();

        $totalRows = $row['total'];
        $totalPages = ceil($totalRows / $limit);

        return $totalPages;
    }

    public function createProduct($nombre, $descripcion, $valor, $tienda, $imagen)
    {
        $uploadDir = '../assets/img/';
        $dateNow = new DateTime();

        // Validar si hay una imagen
        if (!empty($imagen)) {
            $rutaImagen = $this->uploadImage($uploadDir, $dateNow, $imagen);
        } else {
            // Imagen por defecto
            $nameFileImage = 'img.jpg';
            $rutaImagen = $uploadDir . $nameFileImage;
        }

        $query = "INSERT INTO producto (nombre, descripcion, valor, tienda, imagen) VALUES ('$nombre', '$descripcion', '$valor', '$tienda', '$rutaImagen')";
        $this->connection->query($query);
    }

    public function getProduct($sku)
    {
        $query = "SELECT * FROM producto WHERE sku = $sku";
        $result = $this->connection->query($query);
        return $result->fetch_assoc();
    }

    public function updateProduct($sku, $nombre, $descripcion, $valor, $imagen)
    {
        $uploadDir = '../assets/img/';
        $dateNow = new DateTime();

        // Validar si se proporcionó una imagen
        if (!empty($imagen)) {
            $rutaImagen = $this->uploadImage($uploadDir, $dateNow, $imagen);
        } else {
            // En caso de que no se proporcione ninguna imagen, asignar un valor por defecto
            $nameFileImage = 'img.jpg';
            $rutaImagen = $uploadDir . $nameFileImage;
        }

        $query = "UPDATE producto SET nombre = '$nombre', descripcion = '$descripcion', valor = '$valor', imagen = '$rutaImagen' WHERE sku = $sku";
        $this->connection->query($query);
    }

    public function deleteProduct($sku)
    {
        // Obtener la ruta de la imagen del producto
        $query = "SELECT imagen FROM producto WHERE sku = $sku";
        $result = $this->connection->query($query);
        $row = $result->fetch_assoc();
        $rutaImagen = $row['imagen'];

        // Eliminar la imagen del servidor
        if (!empty($rutaImagen) && file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }

        // Eliminar el producto de la base de datos
        $query = "DELETE FROM producto WHERE sku = $sku";
        $this->connection->query($query);
    }

    private function uploadImage($uploadDir, $dateNow, $imagen)
    {
        $nameFileImage = $dateNow->getTimestamp() . '_' . $imagen['name'];
        $tmpImage = $imagen['tmp_name'];
        $rutaImagen = $uploadDir . $nameFileImage;

        if (move_uploaded_file($tmpImage, $rutaImagen)) {
            return $rutaImagen;
        } else {
            throw new Exception("Error al subir la imagen del producto.");
        }
    }
}
