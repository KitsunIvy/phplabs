<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказать услугу</title>
</head>
<body>
    <form action="#" method="post">
        <input type="text" name="name" placeholder="Имя"></input>
        <select name="product">
            <option disabled selected>Выберите услугу:</option>
            <?php
            $mysqli = new mysqli("db", "user", "password", "appDB");
            $mysqli->set_charset("utf8mb4");
            $products = $mysqli->query("SELECT * FROM products");
            foreach ($products as $row) {
                echo "<option value=\"{$row['ID']}\">{$row['name']}</option>";
            }
            ?>
        </select>
        <button>Заказать</button>
    </form>
</body>
</html>
