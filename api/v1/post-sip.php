<?php

include "cek-no-token.php";

$size = 0;

foreach ($_FILES as $key => $element) {
    $size = $size + $element['size'];
    if ($size >= 2000000) {
        $datax['code'] = 500;
        $datax['msg'] = 'Data Terlalu Besar';
        echo json_encode($datax);
        die();
    }
    $element['image'] = ("data:" . $element['type'] . ";base64," . base64_encode(file_get_contents($element['tmp_name'])));
    $get[] = $element;
}
$post['size'] = $size;
$post['data'] = $get;

echo json_encode($post);
