<?php
include "cek-token.php";

//email, pw_lama, pw_baru

$data['password'] = md5($pw_baru);
$pw_lama = md5($pw_lama);

if ($pw_baru == $pw_lama) {
	$datax['code'] = 500;
	$datax['msg'] = 'Password lama dan password baru tidak boleh sama';
	echo json_encode($datax);
	die();
}

$pw_lama_real = baca_tabel('dd_user', 'password', "where username='$email'");

if ($pw_lama_real == $pw_lama) {
	$result = update_tabel('dd_user', $data, "where username='$email' and password='$pw_lama'");
	if ($result) {
		$datax['code'] = 200;
		$datax['msg'] = 'Password berhasil diubah';
		$datax['res'] = $data;
	} else {
		$datax['code'] = 500;
		$datax['msg'] = "Maaf, Password Gagal diubah";
	}
} else {
	$datax['code'] = 500;
	$datax['msg'] = 'Password Lama Tidak Sesuai';
}


echo json_encode($datax);
?>