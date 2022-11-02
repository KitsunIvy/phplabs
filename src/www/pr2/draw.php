<?php
function parse_num($num) {
    switch (substr($num, 0, 2)) {
        case "0b":
            $num = bindec($num);
            break;
        case "0x":
            $num = hexdec($num);
            break;
    }
    settype($num, "integer");

    $num &= 0xffffffffffff;

    // Структура числа:
    // xx | xxxxxx | xxxx
    // |    |  |  |  |   |
    // v    v  v  v  v   -> опция 2
    // тип  r  g  b  опция 1
    $type = $num >> 10 * 4;
    $color = sprintf("%06x", $num >> 4 * 4 & 0xffffff);
    $options = [
        "first" => $num >> 2 * 4 & 0xff,
        "second" => $num & 0xff,
    ];

    return [
        "type" => $type,
        "color" => $color,
        "options" => $options,
    ];
}

function draw($options) {
    $svg = '<svg width="512" height="512">';

    switch ($options["type"]) {
        case 0:
            $svg .= "<circle cx=\"50%\" cy=\"50%\" r=\"{$options['options']['first']}\" ";
            break;
        case 1:
            $svg .= "<ellipse cx=\"50%\" cy=\"50%\" rx=\"{$options['options']['first']}\" ry=\"{$options['options']['second']}\" ";
            break;
        case 2:
            $offsetX = 256 - $options["options"]["first"] / 2;
            $offsetY = 256 - $options["options"]["second"] / 2;
            $svg .= "<rect x=\"$offsetX\" y=\"$offsetY\" width=\"{$options['options']['first']}\" height=\"{$options['options']['second']}\" ";
            break;
    }

    $svg .= "fill=\"#{$options['color']}\" /></svg>";
    return $svg;
}
