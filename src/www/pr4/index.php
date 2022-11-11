<?php
require __DIR__ . "/api/product.php";
require __DIR__ . "/api/order.php";

header("Content-Type: application/json");
$mysqli = new mysqli("db", "user", "password", "appDB");
$mysqli->set_charset("utf8mb4");

$method = $_SERVER["REQUEST_METHOD"];
$query = $_GET["q"];
$params = explode("/", $query);
$type = $params[0];
if (isset($params[1]) && $params[1]) {
    $id = $params[1];
}

switch ($method) {
    case "GET":
        switch ($type) {
            case "products":
                if (isset($id)) {
                    echo json_encode(get_product($mysqli, $id));
                } else {
                    echo json_encode(get_products($mysqli));
                }
                break;
            case "orders":
                if (isset($id)) {
                    echo json_encode(get_order($mysqli, $id));
                } else {
                    echo json_encode(get_orders($mysqli));
                }
                break;
        }
        break;
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        switch ($type) {
            case "products":
                echo json_encode(create_product($mysqli, $data));
                break;
            case "orders":
                echo json_encode(create_order($mysqli, $data));
                break;
        }
        break;
    case "PATCH":
        $data = json_decode(file_get_contents("php://input"), true);
        switch ($type) {
            case "products":
                if (isset($id)) {
                    echo json_encode(update_product($mysqli, $id, $data));
                }
                break;
            case "orders":
                if (isset($id)) {
                    echo json_encode(update_order($mysqli, $id, $data));
                }
                break;
        }
        break;
    case "DELETE":
        switch ($type) {
            case "products":
                if (isset($id)) {
                    echo json_encode(delete_product($mysqli, $id));
                }
                break;
            case "orders":
                if (isset($id)) {
                    echo json_encode(delete_order($mysqli, $id));
                }
                break;
        }
        break;
}
