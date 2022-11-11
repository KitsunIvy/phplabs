<?php
function get_products($mysqli) {
    $products = mysqli_query($mysqli, "SELECT * FROM products");
    $list = [];
    foreach ($products as $row) {
        $list[] = $row;
    }
    $res = [
        "status" => true,
        "products" => $list
    ];
    return $res;
}

function get_product($mysqli, $id) {
    $product = mysqli_query($mysqli, "SELECT * FROM products WHERE ID = {$id}");
    if (is_bool($product)) {
        http_response_code(400);
        $res = [
            "status" => false,
            "message" => "Wrong syntax"
        ];
    } elseif (mysqli_num_rows($product) == 0) {
        http_response_code(404);
        $res = [
            "status" => false,
            "message" => "Product not found"
        ];
    } else {
        $res = ["status" => true] + mysqli_fetch_assoc($product);
    }
    return $res;
}

function create_product($mysqli, $data) {
    if (!isset($data["name"]) || !isset($data["price"])) {
        http_response_code(400);
        $res = [
            "status" => false,
            "message" => "Wrong syntax"
        ];
    }
    $query = mysqli_query($mysqli, "INSERT INTO products (`name`, price) VALUES ('{$data["name"]}', {$data["price"]})");
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
    return $res;
}

function update_product($mysqli, $id, $data) {
    $product = get_product($mysqli, $id);
    if (!$product["status"]) {
        http_response_code(400);
        $res = [
            "status" => false,
            "message" => "Incorrect product ID"
        ];
    } else {
        if (!isset($data["name"]) && !isset($data["price"])) {
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
            if (isset($data["price"])) {
                $sets[] = "price = {$data["price"]}";
            }
            $sets_str = implode(", ", $sets);
            $query = mysqli_query($mysqli, "UPDATE products SET {$sets_str} WHERE products.ID = {$id}");
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

function delete_product($mysqli, $id) {
    $product = get_product($mysqli, $id);
    if (!$product["status"]) {
        http_response_code(400);
        $res = [
            "status" => false,
            "message" => "Incorrect product ID"
        ];
    } else {
        $orders = mysqli_query($mysqli, "SELECT * FROM orders WHERE product_id = {$id}");
        if (mysqli_num_rows($orders) != 0) {
            http_response_code(409);
            $res = [
                "status" => false,
                "message" => "There are orders that depend on this product ID"
            ];
        } else {
            $query = mysqli_query($mysqli, "DELETE FROM products WHERE ID = {$id}");
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
