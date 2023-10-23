<?php
include "cek-no-token.php";

// id, tabs

$cek = baca_tabel('tabs', 'count(*)', "where nama='$tabs'");

if ($cek <= 0) {
	$datax['code'] = 404;
	$datax['msg'] = "Data Tidak Ditemukan";
	echo encryptData($datax);
	die();
}

$cek = baca_tabel($tabs, 'count(*)', "where id='$id'");

if ($cek <= 0) {
	$datax['code'] = 404;
	$datax['msg'] = "Data Tidak Ditemukan";
	echo encryptData($datax);
	die();
}

$datax['code'] = 200;
$datax['msg'] = "Berhasil";

echo encryptData($datax);
