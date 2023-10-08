<?php

include 'cek-no-token.php';

// username, password

$pass = enkrip($password);

$cekemail = baca_tabel('user', 'count(*)', "where email = '$username' or no_hp = '$username' or username = '$username'");

if ($cekemail > 0) {
    $cek = baca_tabel('user', "count(*)", "where (email = '$username' or no_hp = '$username' or username = '$username') and password = '$pass'");
    if ($cek > 0) {

        $data['id_user'] = baca_tabel('user', 'id', "where (email = '$username' or no_hp = '$username' or username = '$username') and pass = '$pass'");
        $data['token'] = generateID(50, 'login', 'token');
        $data['waktu'] = date("Y-m-d H:i:s");

        $update = insert_tabel('login', $data);

        if ($update) {
            $dataRes['code'] = 200;
            $dataRes['msg'] = $data['token'];
        } else {
            $dataRes['code'] = 500;
            $dataRes['msg'] = 'Login Gagal';
        }
    } else {
        $dataRes['code'] = 300;
        $dataRes['msg'] = 'Login Gagal';
    }
} else {
    $dataRes['code'] = 500;
    $dataRes['msg'] = 'Email tidak terdaftar';
}

echo encryptData($dataRes);