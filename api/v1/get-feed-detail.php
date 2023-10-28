<?php
include "cek-no-token.php";

// id

// $db->debug = true;

$id_tabs = baca_tabel("feed", "id_tabs", "where id='$id'");

if (!$id_tabs || $id_tabs == '') {
	$datax['code'] = 404;
	$datax['msg'] = "Data Tidak Ditemukan";
	echo encryptData($datax);
	die();
}

$sql = "SELECT a.id, a.kode, b.nama as tabs, 
a.caption, a.waktu, c.nama, c.foto 
FROM feed a 
JOIN tabs b ON a.id_tabs=b.id 
JOIN user c ON a.id_user=c.id 
WHERE a.id='$id'";

$run = $db->Execute($sql);

while ($get = $run->fetchRow()) {
	$waktu_pertama = strtotime($get['waktu']);
	$waktu_terakhir = strtotime(date_time());
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

	$tabs = $get['tabs'];
	$kode = $get['kode'];

	$get['tabs'] = 'feed';

	$idTabsFeed = '1b2IDNZbMY5JJ0e';

	$sqlImg = "SELECT id FROM tabs_img WHERE kode='$id' and id_tabs='$idTabsFeed'";

	$runImg = $db->Execute($sqlImg);

	while ($getImg = $runImg->fetchRow()) {
		$idImg = $getImg['id'];
		$images[] = image_link('feed', $idImg);
	}

	$get['images'] = $images;
	unset($images);

	$get['jml_like'] = baca_tabel('likes', 'count(*)', "where kode='$id' and id_tabs='$idTabsFeed'");
	$get['jml_comment'] = baca_tabel('comment', 'count(*)', "where kode='$id' and id_tabs='$idTabsFeed'");

	if ($tabs != 'feed') {
		$idImg = baca_tabel("tabs_img", 'id', "where id_tabs='$id_tabs' and kode='$kode'");
		$detail['id'] = $kode;
		$detail['tabs'] = $tabs;
		$detail['image'] = image_link($tabs, $idImg);
	}

	unset($get['kode']);

	$get['detail'] = $detail;

	$data = $get;
}

if (is_array($data)) {
	$datax['code'] = 200;
	$datax['feed'] = $data;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Data Tidak Ditemukan";
}
echo encryptData($datax);
