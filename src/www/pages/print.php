<?php
function print_c($command) {
    exec($command, $output);
    echo "<pre>$command: \n\n";
    foreach ($output as $line) {
        echo "$line<br>";
    }
    echo "</pre>";
}
