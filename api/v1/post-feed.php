<?php
include "cek-token.php";

// caption, tabs, kode

$cekTabs = baca_tabel('tabs', 'count(*)', "where nama = '$tabs'");

if (!$tabs || $tabs == '' || $cekTabs == 0) {
	$datax['code'] = 404;
	$datax['msg'] = "Tab Tidak Terdaftar";
	echo encryptData($datax);
	die();
}

$id_tabs = baca_tabel('tabs', 'id', "where nama = '$tabs'");
$id_feed = generateID(50, 'feed', 'id');

if ($id_tabs == '1b2IDNZbMY5JJ0e') {
	$dataFeed['kode'] = $id_feed;
} else {
	$dataFeed['kode'] = $kode;
}

$dataFeed['id'] = $id_feed;
$dataFeed['id_tabs'] = $id_tabs;
$dataFeed['caption'] = $caption;
$dataFeed['id_user'] = $id_user;
$dataFeed['waktu'] = date_time();

$result = insert_tabel('feed', $dataFeed);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Feed';
	$datax['tabs'] = 'feed';
	$datax['kode'] = $id_feed;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Feed";
}
echo encryptData($datax);
