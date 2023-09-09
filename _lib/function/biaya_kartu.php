<?
include_once "function.olah_tabel.php";

if (!function_exists("biaya_kartu")) {
	function biaya_kartu($no_registrasi) {
		if (!is_numeric($no_registrasi)) return "0";

		//PUNK-25/06/2013-11:28:00 
		//$jmlKartu = baca_tabel("tc_trans_kartu","COUNT(no_registrasi)","WHERE flag_bayar=0 AND no_registrasi=".$no_registrasi);
		$jmlKartu = baca_tabel("tc_trans_kartu","jumlah_transaksi","WHERE flag_bayar=0 AND no_registrasi=".$no_registrasi." GROUP BY no_registrasi,no_kunjungan,jumlah_transaksi");
		$biayaKartu = baca_tabel("mt_master_tarif_kartu a,mt_tgl_tarif b","a.bill_rs","WHERE a.kode_tgl_tarif=b.kode_tgl_tarif AND b.status=1");

		if ($jmlKartu>0) {
			return $jmlKartu * $biayaKartu;
		} else {
			return "0";
		}
	}
}

if (!function_exists("biaya_kartu_kasir")) {
	function biaya_kartu_kasir($no_mr) {
		if ($no_mr!="") return "0";

		$jmlKartu = baca_tabel("tc_trans_kartu","COUNT(no_mr)","WHERE flag_bayar=0 AND no_mr=".$no_mr);
		$biayaKartu = baca_tabel("mt_master_tarif_kartu a,mt_tgl_tarif b","a.bill_rs","WHERE a.kode_tgl_tarif=b.kode_tgl_tarif AND b.status=1");

		if ($jmlKartu>0) {
			return $jmlKartu * $biayaKartu;
		} else {
			return "0";
		}
	}
}

if (!function_exists("biaya_kartu_selesai")) {
	function biaya_kartu_selesai($no_registrasi) {
		if (!is_numeric($no_registrasi)) return "0";

		$jmlKartu = baca_tabel("tc_trans_kartu","COUNT(no_mr)","WHERE flag_bayar=1 AND no_registrasi=".$no_registrasi);
		$biayaKartu = baca_tabel("mt_master_tarif_kartu a,mt_tgl_tarif b","a.bill_rs","WHERE a.kode_tgl_tarif=b.kode_tgl_tarif AND b.status=1");
		
		if ($jmlKartu>0) {
			return $jmlKartu * $biayaKartu;
		} else {
			return "0";
		}
	}
}
if (!function_exists("biaya_kartu_nk")) {
	function biaya_kartu_nk($no_registrasi) {
		if (!is_numeric($no_registrasi)) return "0";

		$jmlKartu = baca_tabel("tc_trans_kartu","COUNT(no_mr)","WHERE flag_bayar=1 AND no_registrasi=".$no_registrasi);
		$status_nk = baca_tabel("tc_trans_kartu","status_nk","WHERE  no_registrasi=".$no_registrasi);
		
		if ($jmlKartu>0) {
			return $status_nk;
		} else {
			return "0";
		}
	}
}
?>