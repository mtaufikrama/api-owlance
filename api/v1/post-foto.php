<?php

include "cek-token.php";

// id, foto

foreach ($_FILES as $key => $val) {
    $$key = $val;
}

if (!$foto || $foto == '') {
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

$feedImg['image'] = ("data:" . $foto['type'] . ";base64," . base64_encode(file_get_contents($foto['tmp_name'])));
$result = update_tabel('user', $feedImg, "where id_user='$id_user'");

if ($result) {
    $datax['code'] = 200;
    $datax['msg'] = 'Foto Berhasil diupload';
} else {
    $datax['code'] = 500;
    $datax['msg'] = 'Foto Gagal diupload';
}

echo encryptData($datax);
