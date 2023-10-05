<?php
include "cek-token.php";

$cektoken = baca_tabel('login', 'token', "where token = '$authorized'");

if ($cektoken) {
	$dataRes['code'] = 200;
	$dataRes['msg'] = 'Berhasil Masuk';
} else {
	$dataRes['code'] = 500;
	$dataRes['msg'] = 'Akses Ditolak';
}
echo encryptData($dataRes);
