<?php
include "cek-token.php";

$sql = "SELECT caption FROM kritik_saran WHERE id_user='$id_user' order by waktu desc";

$run = $db->Execute($sql);

while ($get = $run->fetchRow()) {
	$kritiksaran[] = $get;
}

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil';
	$datax['kritik_saran'] = $kritiksaran;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Kritik Saran";
}
echo encryptData($datax);