<?php

include "../src/export.php";

$password = randomString();

$data['code'] = 200;
$data['msg'] = $password;

echo json_encode($data);