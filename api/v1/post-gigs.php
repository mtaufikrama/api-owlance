<?php
include "cek-token.php";

// title, caption

$dataGigs['id'] = generateID(50, 'gig', 'id');
$dataGigs['id_user'] = $id_user;
$dataGigs['title'] = $title;
$dataGigs['caption'] = $caption;
$dataGigs['waktu'] = date_time();

$result = insert_tabel('gig', $dataGigs);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Gigs';
	$datax['kode'] = $dataGigs['id'];
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Gigs";
}
echo encryptData($datax);
