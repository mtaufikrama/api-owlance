<?php

include 'cek-no-token.php';

//username
if ($username) {

    $cek = baca_tabel("user", "count(*)", "where username='$username'");
    
    if ($cek > 0) {
        $datarest['code'] = 500;
        $datarest['msg'] = "Username Sudah Terdaftar";
    } else {
        $datarest['code'] = 200;
        $datarest['msg'] = "Username Bisa Digunakan";
    }
} else {
    $datarest['code'] = 500;
    $datarest['msg'] = "Username Sudah Terdaftar";
}

echo encryptData($datarest);