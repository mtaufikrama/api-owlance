<?php
include "cek-no-token.php";

// id, nama

$id_tabs = baca_tabel('tabs', 'id', "where nama='$nama'");

$id_tabs_user = baca_tabel("feed", "kode", "where id_tabs='$id_tabs' and id='$id'");

if (!$id_tabs_user || $id_tabs_user == '') {
	$datax['code'] = 404;
	$datax['msg'] = "Data Tidak Ditemukan";
	echo encryptData($datax);
	die();
}

if (is_array($data)) {
	$datax['code'] = 200;
	$datax['data'] = $data;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Data Tidak Ditemukan";
}
echo encryptData($datax);
