<?php

include "cek-token.php";
include "../antol/cek-jenis-kelamin.php";

//jenis_kelamin

if ($kelamin) {
    $data['code'] = 200;
    $data['msg'] = $kelamin;
} else {
    $data['code'] = 500;
    $data['msg'] = 'Jenis Kelamin Gagal Ditemukan';
}
echo encryptData($data);
