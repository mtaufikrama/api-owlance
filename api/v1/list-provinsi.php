<?php
include "cek-token.php";

$Sql = "SELECT id_provinsi as kode, nama_provinsi as nama from provinsi";

$Run = $db->Execute($Sql);

while ($Tpl = $Run->fetchRow()) {
	$data[] = $Tpl;
}

if (is_array($data)) {
	$datax['code'] = 200;
	$datax['list'] = $data;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Tidak ada data ditemukan";
}
echo encryptData($datax);