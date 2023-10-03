<?php

include "cek-token.php";
include "../antol/cek-jenis-kelamin.php";

//username

$cek = baca_tabel("user", "count(username)", "where username='$username'");

if ($cek > 0) {

    $datarest['code'] = 500;
    $datarest['msg'] = "Email Sudah Terdaftar";
    echo json_encode($datarest);
    die();

}

if ($kelamin) {
    $data['code'] = 200;
    $data['msg'] = $kelamin;
} else {
    $data['code'] = 500;
    $data['msg'] = 'Jenis Kelamin Gagal Ditemukan';
}
echo json_encode($data);