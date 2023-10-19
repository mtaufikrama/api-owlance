<?php
include "cek-token.php";

// caption, array(images)

$dataGigs['id'] = generateID(50, 'gigs', 'id');
$dataGigs['id_user'] = $id_user;
$dataGigs['title'] = $title;
$dataGigs['caption'] = $caption;
$dataGigs['waktu'] = date("Y-m-d H:i:s");

$result = insert_tabel('gigs', $dataGigs);

if ($result) {
	foreach ($images as $image) {
		$gigsImg['id'] = generateID(50, 'gigs_img', 'id');
		$gigsImg['id_gigs'] = $dataGigs['id'];
		$gigsImg['image'] = $image;
		$result = insert_tabel('gigs_img', $gigsImg);
		unset($gigsImg);
	}
	if ($result) {
		$datax['code'] = 200;
		$datax['msg'] = 'Berhasil Mengupload Gigs';
		$datax['kode'] = $dataGigs['id'];
	} else {
		$datax['code'] = 500;
		$datax['msg'] = 'Gagal Mengupload Gambar';
	}
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Gigs";
}
echo encryptData($datax);
