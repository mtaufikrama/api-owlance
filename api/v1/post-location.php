<?php
include "cek-token.php";

// lng, lat

$location['latitude'] = $lat;
$location['longitude'] = $lng;

$result = update_tabel('login', $location, "where id_user = '$id_user' and token='$authorized'");

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Lokasi';
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Lokasi";
}
echo encryptData($datax);
