<?php
include "cek-token.php";

// tabs, id, comment

if (!$comment || $comment == '') {
	$datax['code'] = 500;
	$datax['msg'] = "comment tidak ada";
	echo encryptData($datax);
	die();
}

$cek = baca_tabel('tabs', 'count(*)', "where nama='$tabs'");

if ($cek <= 0) {
	$datax['code'] = 404;
	$datax['msg'] = "Data Tidak Ditemukan";
	echo encryptData($datax);
	die();
}

$id_tabs = baca_tabel('tabs', 'id', "where nama='$tabs'");

$dataComment['id'] = generateID(50, 'comment', 'id');
$dataComment['id_user'] = $id_user;
$dataComment['id_tabs'] = $id_tabs;
$dataComment['kode'] = $id;
$dataComment['comment'] = $comment;
$dataComment['waktu'] = date_time();

$result = insert_tabel('comment', $dataComment);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Comment';
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Comment";
}
echo encryptData($datax);
