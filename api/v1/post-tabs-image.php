<?php

include "cek-token.php";

//array(files), tabs, kode

$id_tabs = baca_tabel("tabs", "id", "where nama='$tabs'");

if (!$id_tabs || $id_tabs == '') {
    $datax['code'] = 404;
    $datax['msg'] = "Data Tidak Ditemukan";
    echo encryptData($datax);
    die();
}

if (!is_array($_FILES)) {
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
    $images[] = $element;
}

foreach ($images as $image) {
    $userImg['id'] = generateID(50, 'tabs_img', 'id');
    $userImg['id_tabs'] = $id_tabs;
    $userImg['kode'] = $kode;
    $userImg['mime_type'] = $image['type'];
    $userImg['image'] = base64_encode(file_get_contents($image['tmp_name']));
    $userImg['waktu'] = date_time();
    $result = insert_tabel('tabs_img', $userImg);
}

echo json_encode($feed);
