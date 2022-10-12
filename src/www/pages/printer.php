<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PR2 Print</title>
</head>
<body>
    <?php
        require __DIR__ . "/print.php";
        foreach (["ls", "whoami", "ps", "id"] as $command) {
            print_c($command); echo "\n";
        }
    ?>
</body>
</html>
