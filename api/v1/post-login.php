<?php

include 'cek-no-token.php';

// username, password, device_data

$pass = enkrip($password);

$cekemail = baca_tabel('user', 'count(*)', "where email = '$username' or no_hp = '$username' or username = '$username'");

if ($cekemail > 0) {
    $cek = baca_tabel('user', "count(*)", "where (email = '$username' or no_hp = '$username' or username = '$username') and password = '$pass'");
    if ($cek > 0) {
        $json_device = json_encode($device_data);
        $id_user = baca_tabel('user', 'id', "where (email = '$username' or no_hp = '$username' or username = '$username') and password = '$pass'");
        $id_roles = baca_tabel('user', 'id_roles', "where id='$id_user'");
        $token = baca_tabel('login', 'token', "where id_user = '$id_user' and device_data = '$json_device'");
        if (!$token || $token == '') {
            $data['id_user'] = $id_user;
            $data['token'] = generateID(50, 'login', 'token');
            $data['device_data'] = $json_device;
            $data['waktu'] = date("Y-m-d H:i:s");
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
            $data['waktu'] = date("Y-m-d H:i:s");
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
        $dataRes['code'] = 500;
        $dataRes['msg'] = 'Password Salah';
    }
} else {
    $dataRes['code'] = 500;
    $dataRes['msg'] = 'Email tidak terdaftar';
}

echo encryptData($dataRes);
