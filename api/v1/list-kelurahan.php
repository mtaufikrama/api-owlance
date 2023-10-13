<?php
include "cek-token.php";

//id_kecamatan

if (!$id_kecamatan) {
	$datax['code'] = 500;
	$datax['msg'] = "ID Kecamatan tidak ada";
	echo encryptData($datax);
	die();
}

$SqlGetSpesialisasi = "SELECT id_kelurahan as kode, nama_kelurahan as nama, kode_pos from kelurahan where id_kecamatan='$id_kecamatan'";

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
