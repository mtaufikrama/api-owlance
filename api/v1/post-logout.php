<?php

include "cek-token.php";

$delete = delete_tabel('login', "where token = '$token'");

if ($delete) {
    $dataRes['code'] = 200;
    $dataRes['msg'] = 'Berhasil Logout';
} else {
    $dataRes['code'] = 300;
    $dataRes['msg'] = 'Gagal Logout';
}

echo encryptData($dataRes);
