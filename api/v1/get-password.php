<?php

include 'cek-no-token.php';

$password = randomString();

$data['code'] = 200;
$data['msg'] = $password;

echo encryptData($data);