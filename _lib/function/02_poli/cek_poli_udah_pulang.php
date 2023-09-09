<?
if (!function_exists("cek_poli_udah_pulang")) {
	function cek_poli_udah_pulang($no_registrasi) {
		global $db;

		$qry = "SELECT COUNT(no_kunjungan) AS adakah FROM tc_kunjungan WHERE no_registrasi=".$no_registrasi." AND kode_bagian_tujuan LIKE '01%' AND (tgl_keluar IS NULL OR status_keluar IS NULL)";

		$resultset=&$db->Execute($qry);
		return $resultset->fields["adakah"];
	}
}
?>