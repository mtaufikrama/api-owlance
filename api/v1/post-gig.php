<?php
include "cek-token.php";

// title, caption, price

$id_gig = generateID(50, 'gig', 'id');
$dataGig['id'] = $id_gig;
$dataGig['id_user'] = $id_user;
$dataGig['title'] = $title;
$dataGig['caption'] = $caption;
$dataGig['price'] = $price;
$dataGig['waktu'] = date_time();

$result = insert_tabel('gig', $dataGig);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Gig';
	$datax['tabs'] = 'gig';
	$datax['kode'] = $id_gig;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Gig";
}
echo encryptData($datax);
