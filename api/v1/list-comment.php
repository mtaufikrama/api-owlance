<?php
include "cek-token.php";

// id

$SqlGetSpesialisasi = "SELECT a.comment, a.rate, b.username, b.foto from comment a join user b on a.id_user=b.id where id_gigs='$id'";

$RunGetSpesialisasi = $db->Execute($SqlGetSpesialisasi);

while ($TplGetSpesialisasi = $RunGetSpesialisasi->fetchRow()) {
	$data[] = $TplGetSpesialisasi;
}

if (is_array($data)) {
	$datax['code'] = 200;
	$datax['kelurahan'] = $data;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Tidak ada data ditemukan";
}
echo encryptData($datax);
