<?php
require_once '../models/Shop.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getShopsByPage':
        $shopModel = new Shop();

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;

        $shops = $shopModel->getShopsByPage($page, $limit);
        $totalPages = $shopModel->getTotalPages($limit);

        $response = [
            'data' => $shops,
            'totalPages' => $totalPages
        ];

        echo json_encode($response);
        break;

    case 'saveShop':
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $fechaApertura = $_POST['fechaApertura'];

        $shopModel = new Shop();
        if ($id) {
            $shopModel->updateShop($id, $nombre, $fechaApertura);
        } else {
            $shopModel->createShop($nombre, $fechaApertura);
        }
        break;

    case 'getShop':
        $id = $_GET['id'];

        $shopModel = new Shop();
        $tienda = $shopModel->getShop($id);

        echo json_encode($tienda);
        break;

    case 'deleteShop':
        $id = $_POST['id'];

        $shopModel = new Shop();
        $shopModel->deleteShop($id);
        break;
}
