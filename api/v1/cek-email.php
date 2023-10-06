<?php

include "../src/export.php";

//email
$cek = baca_tabel("user", "count(email)", "where email='$email'");

if ($cek > 0) {
    $data['code'] = 500;
    $data['msg'] = "Email Sudah Digunakan!";
} else {
    $data['code'] = 200;
    $data['msg'] = "Email tidak Terdaftar";
}

echo encryptData($data);