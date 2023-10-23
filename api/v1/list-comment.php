<?php
include "cek-no-token.php";

// tabs, id
// $db->debug = true;
$cek = baca_tabel('tabs', 'count(*)', "where nama='$tabs'");

if ($cek <= 0) {
	$datax['code'] = 404;
	$datax['msg'] = "Tidak ada data ditemukan";
	echo encryptData($datax);
	die();
}

$id_tabs = baca_tabel('tabs', 'id', "where nama='$tabs'");

$sql = "SELECT a.id, a.comment, a.rate, b.username, b.foto 
	from comment a 
	join user b on a.id_user=b.id 
	where a.id_tabs='$id_tabs' and a.kode='$id' order by a.waktu desc";

$run = $db->Execute($sql);

while ($get = $run->fetchRow()) {
	$data[] = $get;
}

if (is_array($data)) {
	$datax['code'] = 200;
	$datax['comment'] = $data;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Tidak ada data ditemukan";
}
echo encryptData($datax);
