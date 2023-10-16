<?php
include "cek-token.php";

// title, caption, tgl_awal, tgl_akhir

if (!$title) {
	$datax['code'] = 500;
	$datax['msg'] = "Pendidikan tidak ada";
	echo encryptData($datax);
	die();
}

$dataEdu['id'] = generateID(15, 'education', 'id');
$dataEdu['id_user'] = $id_user;
$dataEdu['title'] = $title;
$dataEdu['caption'] = $caption;
$dataEdu['tgl_awal'] = $tgl_awal;
$dataEdu['tgl_akhir'] = $tgl_akhir;

$result = insert_tabel('education', $dataEdu);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Feed';
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Feed";
}
echo encryptData($datax);
