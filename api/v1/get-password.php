<?php

include 'cek-no-token.php';

$length = 10;
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';
$randomString = '';
$charLength = strlen($characters);

for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charLength - 1)];
}

$data['code'] = 200;
$data['msg'] = $randomString;

echo encryptData($data);
