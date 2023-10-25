<?php
include "cek-token.php";

// caption

if (!$caption || $caption == '') {
	$datax['code'] = 500;
	$datax['msg'] = "Title tidak ada";
	echo encryptData($datax);
	die();
}

$dataSkill['id'] = generateID(50, 'kritik_saran', 'id');
$dataSkill['id_user'] = $id_user;
$dataSkill['caption'] = $caption;

$result = insert_tabel('kritik_saran', $dataSkill);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Kritik Saran';
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Kritik Saran";
}
echo encryptData($datax);