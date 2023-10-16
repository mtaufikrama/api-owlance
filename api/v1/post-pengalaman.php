<?php
include "cek-token.php";

// title, caption, tgl_awal, tgl_akhir

if (!$title) {
	$datax['code'] = 500;
	$datax['msg'] = "Pendidikan tidak ada";
	echo encryptData($datax);
	die();
}

$dataExp['id'] = generateID(15, 'experience', 'id');
$dataExp['id_user'] = $id_user;
$dataExp['title'] = $title;
$dataExp['caption'] = $caption;
$dataExp['tgl_awal'] = $tgl_awal;
$dataExp['tgl_akhir'] = $tgl_akhir;

$result = insert_tabel('experience', $dataExp);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Pengalaman';
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Pengalaman";
}
echo encryptData($datax);
