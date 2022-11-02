<?php
function parse_arr($arr) {
    return explode(",", $arr);
}

function merge_sort($arr) {
    // Merge sort
    $len = count($arr);
    if ($len == 1) {
        return $arr;
    }
    $mid = intdiv($len, 2);
    return merge(merge_sort(array_slice($arr, 0, $mid)), merge_sort(array_slice($arr, $mid)));
}

function merge($arr1, $arr2) {
    $len1 = count($arr1);
    $len2 = count($arr2);
    $len = $len1 + $len2;
    $res = [];
    $i = $j = 0;
    for ($k = 0; $k < $len; $k++) {
        if ($j < $len2 && $i < $len1) {
            if ($arr1[$i] < $arr2[$j]) {
                $res[$k] = $arr1[$i++];
            } else {
                $res[$k] = $arr2[$j++];
            }
        } else if ($j < $len2) {
            $res[$k] = $arr2[$j++];
        } else {
            $res[$k] = $arr1[$i++];
        }
    }
    return $res;
}
