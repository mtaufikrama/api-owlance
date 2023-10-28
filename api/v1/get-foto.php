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
		$type = 'image/jpeg';
		$foto = null;
	}
} else {
	$cektabs = baca_tabel('tabs', 'count(nama)', "where nama='$tabs'");
	if ($cektabs > 0) {
		$sql = "SELECT mime_type, image from tabs_img where id='$id' order by waktu desc limit 1";
		$run = $db->Execute($sql);
		while ($get = $run->fetchRow()) {
			$type = $get['mime_type'];
			$foto = $get['image'];
		}
	} else {
		$type = 'image/jpeg';
		$foto = null;
		die();
	}
}

header("Content-Type: $type");

echo base64_decode($foto);
