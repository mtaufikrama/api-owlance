<?php

include "cek-token.php";

// foto

foreach ($_FILES as $key => $val) {
    $$key = $val;
}

if (!is_array($foto)) {
    $datax['code'] = 500;
    $datax['msg'] = 'Tidak ada foto yang diinput';
    echo encryptData($datax);
    die();
}

if ($foto['size'] >= 2000000) {
    $datax['code'] = 500;
    $datax['msg'] = 'Data Terlalu Besar';
    echo encryptData($datax);
    die();
}

$userImg['id'] = generateID(50, 'user_img', 'id');
$userImg['id_user'] = $id_user;
$userImg['mime_type'] = $foto['type'];
$userImg['image'] = base64_encode(file_get_contents($foto['tmp_name']));
$userImg['waktu'] = date_time();
$result = insert_tabel('user_img', $userImg);

if ($result) {
    $datax['code'] = 200;
    $datax['msg'] = 'Foto Berhasil diupload';
} else {
    $datax['code'] = 500;
    $datax['msg'] = 'Foto Gagal diupload';
}

echo encryptData($datax);
