<?php
include "cek-token.php";

// caption, array(images)

$dataFeed['id'] = generateID(15, 'feed', 'id');
$dataFeed['id_user'] = $id_user;
$dataFeed['title'] = $title;
$dataFeed['caption'] = $caption;
$dataFeed['waktu'] = date("Y-m-d H:i:s");

$result = insert_tabel('gigs', $dataFeed);

if ($result) {
	foreach ($images as $image) {
		$feedImg['id'] = generateID(15, 'gigs_img', 'id');
		$feedImg['id_gigs'] = $dataFeed['id'];
		$feedImg['image'] = $image;
		$result = insert_tabel('gigs_img', $feedImg);
		unset($feedImg);
	}
	if ($result) {
		$datax['code'] = 200;
		$datax['msg'] = 'Berhasil Mengupload Feed';
	} else {
		$datax['code'] = 500;
		$datax['msg'] = 'Gagal Mengupload Gambar';
	}
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Feed";
}
echo encryptData($datax);
