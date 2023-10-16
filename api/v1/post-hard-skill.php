<?php
include "cek-token.php";

// title, id_experience, caption

if (!$title) {
	$datax['code'] = 500;
	$datax['msg'] = "Title tidak ada";
	echo encryptData($datax);
	die();
}

$dataSkill['id'] = generateID(15, 'hard_skill', 'id');
$dataSkill['id_experience'] = $id_experience;
$dataSkill['id_user'] = $id_user;
$dataSkill['title'] = $title;
$dataSkill['caption'] = $caption;

$result = insert_tabel('hard_skill', $dataSkill);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Hard Skill';
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Hard Skill";
}
echo encryptData($datax);
