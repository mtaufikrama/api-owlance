<?php
include "cek-token.php";

// title, caption, price

$id_project = generateID(50, 'project', 'id');
$dataProject['id'] = $id_project;
$dataProject['id_user'] = $id_user;
$dataProject['title'] = $title;
$dataProject['caption'] = $caption;
$dataProject['price'] = $price;
$dataProject['waktu'] = date_time();

$result = insert_tabel('project', $dataProject);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Project';
	$datax['tabs'] = 'project';
	$datax['kode'] = $id_project;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload project";
}
echo encryptData($datax);
