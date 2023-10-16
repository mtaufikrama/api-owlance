<?php
include "cek-token.php";

// title, caption

if (!$title) {
	$datax['code'] = 500;
	$datax['msg'] = "Pendidikan tidak ada";
	echo encryptData($datax);
	die();
}

$dataSkill['id'] = generateID(15, 'soft_skill', 'id');
$dataSkill['id_user'] = $id_user;
$dataSkill['title'] = $title;
$dataSkill['caption'] = $caption;

$result = insert_tabel('soft_skill', $dataSkill);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Soft Skill';
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Soft Skill";
}
echo encryptData($datax);
