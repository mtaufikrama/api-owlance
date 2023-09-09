<?
session_start();
require_once("db.php");
require_once("function.olah_tabel.php");
require_once("function.form.php");

//$db->debug=true;

if (!function_exists("hitung_bill")) {
	function hitung_bill($no_kunjungan,$kode_tarif,$jumlah="1") {
		if ($no_kunjungan=="" || $kode_tarif=="") die("Parameter Salah");

		$hasil=array();

		$no_mr=baca_tabel("tc_kunjungan","no_mr","WHERE no_kunjungan=".$no_kunjungan);
		$no_registrasi=baca_tabel("tc_kunjungan","no_registrasi","WHERE no_kunjungan=".$no_kunjungan);
		$no_kunjungan_rawat_inap=baca_tabel("tc_kunjungan","no_kunjungan","WHERE no_registrasi=".$no_registrasi." AND kode_bagian_tujuan LIKE '03%'");
		if (is_numeric($no_kunjungan_rawat_inap)) {
			$kode_klas=baca_tabel("ri_tc_rawatinap","kelas_pas","WHERE no_kunjungan=".$no_kunjungan);
			$kode_klas_jatah=baca_tabel("mt_master_pasien","kode_klas","WHERE no_mr=".$no_mr);
		} else {
			$kode_klas="16";
			$kode_klas_jatah="16";
		}

		$rTarif=read_tabel("mt_tarif_v","*","WHERE kode_tarif=".$kode_tarif." AND kode_klas=".$kode_klas);
		$bill_rs=$rTarif->Fields("bill_rs");
		$bill_dr1=$rTarif->Fields("bill_dr1");
		$bill_dr2=$rTarif->Fields("bill_dr2");
		$kode_master_tarif_detail=$rTarif->Fields("kode_master_tarif_detail");

		$rTarifJatah=read_tabel("mt_tarif_v","*","WHERE kode_tarif=".$kode_tarif." AND kode_klas=".$kode_klas_jatah);
		$bill_rs_jatah=$rTarifJatah->Fields("bill_rs");
		$bill_dr1_jatah=$rTarifJatah->Fields("bill_dr1");
		$bill_dr2_jatah=$rTarifJatah->Fields("bill_dr2");
		$kode_master_tarif_detail_jatah=$rTarifJatah->Fields("kode_master_tarif_detail");

		$hasil["no_mr"]=$no_mr;
		$hasil["no_registrasi"]=$no_registrasi;
		$hasil["no_kunjungan_rawat_inap"]=$no_kunjungan_rawat_inap;
		$hasil["kode_klas"]=$kode_klas;
		$hasil["kode_klas_jatah"]=$kode_klas_jatah;
		//$hasil[""]=$;

		$hasil["bill_rs"]=$bill_rs;
		$hasil["bill_dr1"]=$bill_dr1;
		$hasil["bill_dr2"]=$bill_dr2;
		$hasil["bill_rs_askes"]=$bill_rs_askes;
		$hasil["bill_dr1_askes"]=$bill_dr1_askes;
		$hasil["bill_dr2_askes"]=$bill_dr2_askes;
		$hasil["bill_rs_jatah"]=$bill_rs_jatah;
		$hasil["bill_dr1_jatah"]=$bill_dr1_jatah;
		$hasil["bill_dr2_jatah"]=$bill_dr2_jatah;
		$hasil["kode_master_tarif_detail"]=$kode_master_tarif_detail;
		$hasil["kode_master_tarif_detail_jatah"]=$kode_master_tarif_detail_jatah;

		return $hasil;
	} // end of 
} // end of 
?>