<?php
require_once '../models/Product.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getProductsByPage':
        $productModel = new Product();

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 3;
        $shopId = isset($_GET['shop_id']) ? intval($_GET['shop_id']) : 0;

        $products = $productModel->getProductsByPage($page, $limit, $shopId);
        $totalPages = $productModel->getTotalPages($limit, $shopId);

        $response = [
            'data' => $products,
            'totalPages' => $totalPages
        ];

        echo json_encode($response);
        break;

    case 'saveProduct':
        $productModel = new Product();

        $sku = $_POST['sku'];
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
        $tienda = isset($_POST['tienda']) ? $_POST['tienda'] : '';
        $valor = isset($_POST['valor']) ? floatval($_POST['valor']) : 0.0;

        // Verificar si se ha enviado una imagen
        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $_FILES['imagen'];
        }

        // Guardar o actualizar el producto
        if ($sku) {
            $productModel->updateProduct($sku, $nombre, $descripcion, $valor, $imagen);
        } else {
            $productModel->createProduct($nombre, $descripcion, $valor, $tienda, $imagen);
        }
        break;

    case 'getProduct':
        $sku = $_GET['sku'];

        $productModel = new Product();
        $producto = $productModel->getProduct($sku);

        echo json_encode($producto);
        break;

    case 'deleteProduct':
        $sku = $_POST['sku'];

        $productModel = new Product();
        $productModel->deleteProduct($sku);
        break;
}
