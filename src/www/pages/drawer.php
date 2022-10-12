<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PR2 Draw</title>
</head>
<body>
    <?php
        require __DIR__ . "/draw.php";
        $num = $_GET["num"];
        $options = parse_num($num);
        echo draw($options);
    ?>
</body>
</html>
