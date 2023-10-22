<?php
include "cek-no-token.php";

// id

$db->debug = true;

$id_tabs = baca_tabel("feed", "id_tabs", "where id='$id'");

if (!$id_tabs || $id_tabs == '') {
	$datax['code'] = 404;
	$datax['msg'] = "Data Tidak Ditemukan";
	echo encryptData($datax);
	die();
}

$sql = "SELECT a.kode, e.nama as tabs, a.judul, 
	a.caption, a.waktu, b.nama, b.foto, 
	COUNT(c.*) as jml_like, 
	COUNT(d.*) as jml_comment
	FROM feed a 
	JOIN user b ON a.id_user=b.id 
	JOIN like c ON a.id=c.id_feed 
	JOIN comment d ON a.id=d.id_feed
	JOIN tabs e ON a.id_tabs=e.id
	WHERE a.id='$id'";

$run = $db->Execute($sql);

while ($get = $run->fetchRow()) {
	$waktu_pertama = date("Y-m-d H:i:s", strtotime($get['waktu']));
	$waktu_terakhir = date('Y-m-d H:i:s');
	$selisih_detik = $waktu_terakhir - $waktu_pertama;

	$jam = floor($selisih_detik / 3600);
	$sisa_detik = $selisih_detik % 3600;
	$menit = floor($sisa_detik / 60);
	$detik = $selisih_detik;

	if ($jam > 0 && $menit > 0) {
		$pesan = "$jam jam $menit menit yang lalu";
	} elseif ($jam > 0) {
		$pesan = "$jam jam yang lalu";
	} elseif ($menit > 0) {
		$pesan = "$menit menit yang lalu";
	} else {
		$pesan = "$detik detik yang lalu";
	}

	$get['waktu'] = $pesan;

	$sqlImg = "SELECT foto FROM feed_img WHERE id_feed='$id'";

	$runImg = $db->Execute($sqlImg);

	while ($getImg = $runImg->fetchRow()) {
		$images[] = $getImg;
		$get['images'] = $images;
	}
	unset($images);

	$tabs = $get['tabs'];
	$kode = $get['kode'];

	$imageTabs = baca_tabel($tabs . "_img", 'image', "where id_" . $tabs . "='$kode' desc");

	$detail['id'] = $kode;
	$detail['tabs'] = $tabs;
	$detail['image'] = $imageTabs;

	unset($data['kode']);
	unset($data['tabs']);

	$data['detail'] = $detail;

	$data = $get;
}

if (is_array($data)) {
	$datax['code'] = 200;
	$datax['data'] = $data;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Data Tidak Ditemukan";
}
echo encryptData($datax);
