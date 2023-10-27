<?php

include 'cek-no-token.php';

// $db->debug = true;

// username, password, device_data

if (!$username || $username == "" || !$password || $password == "") {
    $datax['code'] = 500;
    $datax['msg'] = 'Email tidak terdaftar';
    echo encryptData($datax);
    die();
}

unset($data);

$pass = base64_encode(enkrip($password));

if (is_numeric($username)) {
    $kondisi = "no_hp = '$username'";
    $cekemail = baca_tabel('user', 'count(*)', 'where ' . $kondisi);
} else {
    $kondisi = "email = '$username' or username = '$username'";
    $cekemail = baca_tabel('user', 'count(*)', 'where ' . $kondisi);
}

if ($cekemail > 0) {
    $cek = baca_tabel('user', "count(*)", "where ($kondisi) and password = '$pass'");
    if ($cek > 0) {
        $available = baca_tabel('user', "available", "where ($kondisi) and password = '$pass'");
        $json_device = json_encode($device_data);
        $id_user = baca_tabel('user', 'id', "where ($kondisi) and password = '$pass'");
        if ($available == 1) {
            $id_roles = baca_tabel('user', 'id_roles', "where id='$id_user'");
            $token = baca_tabel('login', 'token', "where id_user = '$id_user' and device_data = '$json_device'");
            if (!$token || $token == '') {
                $data['id_user'] = $id_user;
                $data['token'] = generateID(50, 'login', 'token');
                $data['device_data'] = $json_device;
                $data['waktu'] = date_time();
                $insert = insert_tabel('login', $data);
                if ($insert) {
                    $dataRes['code'] = 200;
                    $dataRes['msg'] = 'Berhasil Login';
                    $dataRes['token'] = $data['token'];
                    $dataRes['username'] = baca_tabel('user', 'username', "where id='$id_user'");
                    $dataRes['roles'] = baca_tabel('roles', 'nama_roles', "where id='$id_roles'");
                } else {
                    $dataRes['code'] = 500;
                    $dataRes['msg'] = 'Login Gagal';
                }
            } else {
                $data['waktu'] = date_time();
                $update = update_tabel('login', $data, "where id_user = '$id_user' and device_data = '$json_device'");
                if ($update) {
                    $dataRes['code'] = 200;
                    $dataRes['msg'] = 'Berhasil Login';
                    $dataRes['token'] = $token;
                    $dataRes['username'] = baca_tabel('user', 'username', "where id='$id_user'");
                    $dataRes['roles'] = baca_tabel('roles', 'nama_roles', "where id='$id_roles'");
                } else {
                    $dataRes['code'] = 500;
                    $dataRes['msg'] = 'Login Gagal';
                }
            }
        } else {
            $dataRes['code'] = 505;
            $dataRes['msg'] = 'Akun kamu belum terverifikasi';
            $dataRes['id'] = $id_user;
        }
    } else {
        $dataRes['code'] = 500;
        $dataRes['msg'] = 'Password Salah';
    }
} else {
    $dataRes['code'] = 500;
    $dataRes['msg'] = 'Email tidak terdaftar';
}

echo encryptData($dataRes);
