<?php

$file1 = file_get_contents('file1.txt');
$file2 = file_get_contents('file2.txt');

$array1 = explode(PHP_EOL, $file1);
$array2 = explode(PHP_EOL, $file2);

$array3 = array_intersect($array1, $array2);
$array4 = array_diff($array1, $array2);

$file3 = implode(PHP_EOL, $array3);
$file4 = implode(PHP_EOL, $array4);

file_put_contents('file3.txt', $file3);
file_put_contents('file4.txt', $file4);

