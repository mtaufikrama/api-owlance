<?php
include "cek-no-token.php";

// email, otp

$cek = baca_tabel('otp', 'count(*)', "where otp='$otp' and email='$email'");

if ($cek == 0) {
	$datax['code'] = 500;
	$datax['msg'] = 'OTP yang dimasukkan Salah';
} else {
	$result = delete_tabel('otp', "where email='$email'");
	$update['available'] = 1;
	if ($result) $result = update_tabel('user', $update, "where email='$email'");
	if ($result) {
		$datax['code'] = 300;
		$datax['msg'] = 'Silahkan Login';
	} else {
		$datax['code'] = 500;
		$datax['msg'] = 'Terjadi Kesalahan, Silahkan Coba Kembali';
	}
}

echo encryptData($datax);