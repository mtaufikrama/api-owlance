<?php

include "cek-no-token.php";

if ($_FILES == []) {
    $datax['code'] = 500;
    $datax['msg'] = 'Tidak ada foto yang diinput';
    echo encryptData($datax);
    die();
}

$size = 0;

foreach ($_FILES as $key => $element) {
    $size = $size + $element['size'];
    if ($size >= 2000000) {
        $datax['code'] = 500;
        $datax['msg'] = 'Data Terlalu Besar';
        echo json_encode($datax);
        die();
    }
    $images[] = ("data:" . $element['type'] . ";base64," . base64_encode(file_get_contents($element['tmp_name'])));
}

unset($element);

foreach ($images as $image) {
    $feedImg['id'] = generateID(15, 'feed_img', 'id');
    $feedImg['id_feed'] = $id;
    $feedImg['image'] = $image;
    // $result = insert_tabel('feed_img', $feedImg);
    $feed[] = $feedImg;
}

echo json_encode($feed);
