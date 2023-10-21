<?php
include "cek-no-token.php";

// id

$id_tabs = baca_tabel("feed", "id_tabs", "where id='$id'");

if (!$id_tabs || $id_tabs == '') {
	$datax['code'] = 404;
	$datax['msg'] = "Data Tidak Ditemukan";
	echo encryptData($datax);
	die();
}

switch ($id_tabs) {
	case "1b2IDNZbMY5JJ0e":
		$sql = "SELECT a.id, e.nama, a.judul, a.caption, a.waktu, 
		b.nama as nama_pengguna, b.foto, 
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
	case "gxGAOusmXfQRi51":
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
	case "odlScUrxIfVq2y7":
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

	default:
		$datax['code'] = 404;
		$datax['msg'] = "Nama dan ID kosong";
		echo encryptData($datax);
		die;
}

if (is_array($data)) {
	$datax['code'] = 200;
	$datax['data'] = $data;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Data Tidak Ditemukan";
}
echo encryptData($datax);
