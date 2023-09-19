<?php

include "cek-token.php";
include "../antol/cek-jenis-kelamin.php";

//username

$cek = baca_tabel("user", "count(email)", "where email='$email'");

if ($cek > 0) {

    $datarest['code'] = 500;
    $datarest['msg'] = "Email Sudah Digunakan!";

} else {

    $data['code'] = 200;
    $data['msg'] = "Email tidak Terdaftar";

}

echo json_encode($data);
?>