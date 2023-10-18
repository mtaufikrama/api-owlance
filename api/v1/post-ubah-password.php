<?php
include "cek-token.php";

// pw_lama, pw_baru

$md_pw_baru = base64_encode(enkrip($pw_baru));
$pw_lama = base64_encode(enkrip($pw_lama));

if ($md_pw_baru == $pw_lama) {
	$datax['code'] = 500;
	$datax['msg'] = 'Password Lama dan Password Baru Tidak Boleh Sama';
	echo encryptData($datax);
	die();
}

$pw_lama_real = baca_tabel('user', 'password', "where id='$id_user'");

if ($pw_lama_real == $pw_lama) {
	$data['password'] = $md_pw_baru;
	$result = update_tabel('user', $data, "where email='$email' and password='$pw_lama'");
	if ($result) {
		$result = delete_tabel('login', "where id_user='$id_user'");
		$datax['code'] = 200;
		$datax['msg'] = 'Password berhasil diubah';
		$datax['pw'] = $pw_baru;
	} else {
		$datax['code'] = 500;
		$datax['msg'] = "Maaf, Password Gagal diubah";
	}
} else {
	$datax['code'] = 500;
	$datax['msg'] = 'Password Lama Tidak Sesuai';
}


echo encryptData($datax);
