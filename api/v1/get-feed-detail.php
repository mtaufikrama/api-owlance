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

$sql = "SELECT a.kode, b.nama as tabs, 
a.caption, a.waktu, c.nama, c.foto 
FROM feed a 
JOIN tabs b ON a.id_tabs=b.id 
JOIN user c ON a.id_user=c.id 
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

	$sqlImg = "SELECT image FROM feed_img WHERE id_feed='$id'";

	$runImg = $db->Execute($sqlImg);

	while ($getImg = $runImg->fetchRow()) {
		$images[] = $getImg;
		$get['images'] = $images;
	}
	unset($images);

	$tabs = $get['tabs'];
	$kode = $get['kode'];

	$get['jml_like'] = baca_tabel('likes', 'count(*)', "where kode='$kode' and id_tabs='$id_tabs'");
	$get['jml_comment'] = baca_tabel('comment', 'count(*)', "where kode='$kode' and id_tabs='$id_tabs'");

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
