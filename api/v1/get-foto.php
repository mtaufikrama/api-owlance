<?php
include "cek-no-token.php";

// id, tabs

$id = $_GET['id'];
$tabs = $_GET['tabs'];

if ($tabs == 'user') {
	$cekid = baca_tabel('user', 'count(id)', "where id='$id'");
	if ($cekid > 0) {
		$sql = "SELECT mime_type, image from user_img where id='$id' order by waktu desc limit 1";
		$run = $db->Execute($sql);
		while ($get = $run->fetchRow()) {
			$type = $get['mime_type'];
			$foto = $get['image'];
		}
	} else {
		$datax['code'] = 404;
		$datax['msg'] = 'Foto Tidak Ditemukan';
		echo encryptData($datax);
		die();
	}
} else {
	$cektabs = baca_tabel('tabs', 'count(nama)', "where nama='$tabs'");
	if ($cektabs > 0) {
		$sql = "SELECT mime_type, image from " . $tabs . "_img where id='$id' order by waktu desc limit 1";
		$run = $db->Execute($sql);
		while ($get = $run->fetchRow()) {
			$type = $get['mime_type'];
			$foto = $get['image'];
		}
	} else {
		$datax['code'] = 404;
		$datax['msg'] = 'Foto Tidak Ditemukan';
		echo encryptData($datax);
		die();
	}
}

header("Content-Type: $type");

echo base64_decode($foto);
