<?php
include "cek-no-token.php";

// id, otp

$cek = baca_tabel('otp', 'count(*)', "where otp='$otp' and id_user='$id'");

if ($cek == 0) {
	$datax['code'] = 500;
	$datax['msg'] = 'OTP yang dimasukkan Salah';
} else {
	$datax['code'] = 300;
	$datax['msg'] = 'Silahkan Login';
}

echo encryptData($datax);