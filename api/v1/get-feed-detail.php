<?php
include "cek-no-token.php";

// nama, id

switch ($nama) {
	case "feed":
		$sql = "SELECT a.id, a.judul, a.caption, a.waktu, 
		b.nama, b.username, b.foto, 
		COUNT(c.*) as jml_like, 
		COUNT(d.*) as jml_comment
		FROM feed a 
		JOIN user b ON a.id_user=b.id 
		JOIN like c ON a.id=c.id_feed 
		JOIN comment d ON a.id=d.id_feed
		WHERE a.id='$id'";

		$run = $db->Execute($sql);

		while ($get = $run->fetchRow()) {
			$waktu_pertama = $get['waktu'];
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
				$data['images'] = $images;
			}
			$data = $get;
		}
		break;
	case "gig":
		$sql = "SELECT a.id, a.judul, a.caption, a.waktu, 
		b.nama, b.username, b.foto, 
		COUNT(c.*) as jml_like, 
		COUNT(d.*) as jml_comment
		FROM gigs a 
		JOIN user b ON a.id_user=b.id 
		JOIN like c ON a.id=c.id_feed 
		JOIN comment d ON a.id=d.id_feed
		WHERE a.id='$id'";

		$run = $db->Execute($sql);

		while ($get = $run->fetchRow()) {
			$sqlImg = "SELECT foto FROM gigs_img WHERE id_gigs='$id'";

			$runImg = $db->Execute($sqlImg);

			while ($getImg = $runImg->fetchRow()) {
				$images[] = $getImg;
				$data['images'] = $images;
			}
			$data = $get;
		}
		break;
	case "project":
		break;

	default:

		break;
}

if ($nama || $id) {
	$datax['code'] = 200;
	$datax['data'] = $data;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Nama dan ID kosong";
}
echo encryptData($datax);
