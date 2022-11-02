<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>
</head>
<body>
    <h1>Заказы:</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>Услуга</th>
                <th>Цена</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $mysqli = new mysqli("db", "user", "password", "appDB");
            $mysqli->set_charset("utf8mb4");
            $orders = $mysqli->query(
                "SELECT " .
                "orders.ID, " .
                "orders.name AS order_name, " .
                "products.name AS product_name, " .
                "products.price " .
                "FROM orders " .
                "INNER JOIN products ON orders.product_id=products.ID " .
                "ORDER BY ID"
            );
            foreach ($orders as $row) {
                echo
                    "<tr>" .
                    "<td>{$row['ID']}</td>" .
                    "<td>{$row['order_name']}</td>" .
                    "<td>{$row['product_name']}</td>" .
                    "<td>{$row['price']}</td>" .
                    "</tr>"
                ;
            }
            ?>
        </tbody>
    </table>
</body>
</html>
