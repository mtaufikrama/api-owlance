<?php
include "cek-token.php";

$dataRes['code'] = 200;
$dataRes['msg'] = 'Berhasil Masuk';

echo encryptData($dataRes);