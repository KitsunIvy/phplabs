<?php
function get_orders($mysqli) {
    $orders = mysqli_query($mysqli, "SELECT * FROM orders");
    $list = [];
    foreach ($orders as $row) {
        $list[] = $row;
    }
    $res = [
        "status" => true,
        "orders" => $list
    ];
    return $res;
}

function get_order($mysqli, $id) {
    $order = mysqli_query($mysqli, "SELECT * FROM orders WHERE ID = {$id}");
    if (is_bool($order)) {
        http_response_code(400);
        $res = [
            "status" => false,
            "message" => "Wrong syntax"
        ];
    } elseif (mysqli_num_rows($order) == 0) {
        http_response_code(404);
        $res = [
            "status" => false,
            "message" => "Product not found"
        ];
    } else {
        $res = ["status" => true] + mysqli_fetch_assoc($order);
    }
    return $res;
}

function create_order($mysqli, $data) {
    if (!isset($data["name"]) || !isset($data["product_id"])) {
        http_response_code(400);
        $res = [
            "status" => false,
            "message" => "Wrong syntax"
        ];
    } else {
        $product = get_product($mysqli, $data["product_id"]);
        if (!$product["status"]) {
            http_response_code(400);
            $res = [
                "status" => false,
                "message" => "Incorrect product ID"
            ];
        } else {
            $query = mysqli_query($mysqli, "INSERT INTO orders (`name`, product_id) VALUES ('{$data["name"]}', {$data["product_id"]})");
            if (!$query) {
                http_response_code(500);
                $res = [
                    "status" => false,
                    "message" => "Unknown server error"
                ];
            } else {
                http_response_code(201);
                $res = [
                    "status" => true,
                    "id" => mysqli_insert_id($mysqli)
                ];
            }
        }
    }
    return $res;
}

function update_order($mysqli, $id, $data) {
    $order = get_order($mysqli, $id);
    if (!$order["status"]) {
        http_response_code(400);
        $res = [
            "status" => false,
            "message" => "Incorrect order ID"
        ];
    } else {
        if (!isset($data["name"]) && !isset($data["product_id"])) {
            http_response_code(204);
            $res = [
                "status" => true,
                "id" => $id,
                "message" => "No changes",
            ];
        } else {
            $sets = [];
            if (isset($data["name"])) {
                $sets[] = "`name` = '{$data["name"]}'";
            }
            if (isset($data["product_id"])) {
                $product = get_product($mysqli, $data["product_id"]);
                if (!$product["status"]) {
                    http_response_code(400);
                    $res = [
                        "status" => false,
                        "message" => "Incorrect product ID"
                    ];
                    return $res;
                }
                $sets[] = "product_id = {$data["product_id"]}";
            }
            $sets_str = implode(", ", $sets);
            $query = mysqli_query($mysqli, "UPDATE orders SET {$sets_str} WHERE orders.ID = {$id}");
            if (!$query) {
                http_response_code(500);
                $res = [
                    "status" => false,
                    "message" => "Unknown server error"
                ];
            } else {
                $res = [
                    "status" => true,
                    "id" => $id
                ];
            }
        }
    }
    return $res;
}

function delete_order($mysqli, $id) {
    $order = get_order($mysqli, $id);
    if (!$order["status"]) {
        http_response_code(400);
        $res = [
            "status" => false,
            "message" => "Incorrect order ID"
        ];
    } else {
        $query = mysqli_query($mysqli, "DELETE FROM orders WHERE ID = {$id}");
        if (!$query) {
            http_response_code(500);
            $res = [
                "status" => false,
                "message" => "Unknown server error"
            ];
        } else {
            $res = [
                "status" => true,
                "id" => $id
            ];
        }
    }
    return $res;
}
