<?php
include "cek-no-token.php";

// email, otp

$waktu_sekarang = date_time();

$waktu_lalu = date("Y-m-d H:i:s", strtotime($waktu_sekarang . " - 5 minutes"));

$cekOtp = baca_tabel('otp', 'count(*)', "where otp='$otp' and email='$email'");

if ($cekOtp <= 0) {
	$datax['code'] = 500;
	$datax['msg'] = 'OTP yang dimasukkan Salah';
	echo encryptData($datax);
	die();
}

$cekWaktu = baca_tabel('otp', 'count(*)', "where otp='$otp' and email='$email' and waktu >= '$waktu_lalu'");

if ($cekWaktu <= 0) {
	$datax['code'] = 500;
	$datax['msg'] = 'Waktu sudah lebih dari 5 menit, Silahkan Kirim Ulang OTP Kembali';
	echo encryptData($datax);
	die();
}

$result = delete_tabel('otp', "where email='$email or waktu >= '$waktu_lalu''");
$update['available'] = 1;
if ($result) $result = update_tabel('user', $update, "where email='$email'");
if ($result) {
	$datax['code'] = 300;
	$datax['msg'] = 'Silahkan Login';
} else {
	$datax['code'] = 500;
	$datax['msg'] = 'Terjadi Kesalahan, Silahkan Kirim Ulang OTP Kembali';
}

echo encryptData($datax);
