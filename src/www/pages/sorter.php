<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PR2 Sort</title>
</head>
<body>
    <?php
        require __DIR__ . "/sort.php";
        $arr_s = $_GET["arr"];
        $arr = parse_arr($arr_s);

        echo "<pre>"; print_r(merge_sort($arr)); echo "</pre>";
    ?>
</body>
</html>
