<?php

include "cek-token.php";

$delete = delete_tabel('login', "where token = '$authorized'");

if ($delete) {
    $dataRes['code'] = 300;
    $dataRes['msg'] = 'Berhasil Logout';
} else {
    $dataRes['code'] = 500;
    $dataRes['msg'] = 'Gagal Logout';
}

echo encryptData($dataRes);