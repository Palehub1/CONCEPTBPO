<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
require_once 'C:\xampp\htdocs\PRUEBA_TECNICA_CONCEPT_BPO\SRC\productosController.php';



$method = $_SERVER["REQUEST_METHOD"];
$productosController = new ProductosController();

switch ($method) {
    case 'POST':
        $productosController->create();
        break;
    case 'GET':
        if (isset($_GET['id'])) {
            $productosController->show($_GET['id']);
        } else {
            $productosController->read();
        }
        break;
    case 'PUT':
        $productosController->update();
        break;
    case 'DELETE':
        $productosController->delete();
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Metodo no permitido"]);
        break;
}
