<?php
include "cek-token.php";

// caption, array(images), tabs, kode

$cekTabs = baca_tabel('tabs', 'count(*)', "where nama = '$nama'");

if (!$tabs || $tabs == '' || $cekTabs == 0) {
	$datax['code'] = 404;
	$datax['msg'] = "Tab Tidak Terdaftar";
	echo encryptData($datax);
	die();
}

$dataFeed['id'] = generateID(15, 'feed', 'id');
$dataFeed['caption'] = $caption;
$dataFeed['id_user'] = $id_user;
$dataFeed['waktu'] = date("Y-m-d H:i:s");

$result = insert_tabel('feed', $dataFeed);

if ($result) {
	foreach ($images as $image) {
		$feedImg['id'] = generateID(15, 'feed_img', 'id');
		$feedImg['id_feed'] = $dataFeed['id'];
		$feedImg['image'] = $image;
		$result = insert_tabel('feed_img', $feedImg);
		unset($feedImg);
	}
	if ($result) {
		$datax['code'] = 200;
		$datax['msg'] = 'Berhasil Mengupload Feed';
	} else {
		$datax['code'] = 500;
		$datax['msg'] = 'Gagal Mengupload Gambar';
	}
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Feed";
}
echo encryptData($datax);