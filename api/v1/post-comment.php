<?php
include "cek-token.php";

// nama, id, comment

if (!$comment) {
	$datax['code'] = 500;
	$datax['msg'] = "comment tidak ada";
	echo encryptData($datax);
	die();
}

switch ($nama) {
	case 'feed':
		$dataComment['id_feed'] = $id;
		break;
	case 'gigs':
		$dataComment['id_gigs'] = $id;
		break;
	case 'project':
		$dataComment['id_project'] = $id;
		break;
}

$dataComment['id'] = generateID(100, 'comment', 'id');
$dataComment['id_user'] = $id_user;
$dataComment['title'] = $title;
$dataComment['caption'] = $caption;
$dataComment['tgl_awal'] = $tgl_awal;
$dataComment['tgl_akhir'] = $tgl_akhir;

$result = insert_tabel('comment', $dataComment);

if ($result) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil Mengupload Comment';
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Gagal Mengupload Comment";
}
echo encryptData($datax);