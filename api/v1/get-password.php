<?php

include 'cek-no-token.php';

$password = randomString(10, false);

$data['code'] = 200;
$data['msg'] = $password;

echo encryptData($data);
