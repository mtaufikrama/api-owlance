<?
if (!function_exists("bedah_sudah_pulang")) {
	function bedah_sudah_pulang($kode_ri) {
		global $db;

		$qry = "SELECT COUNT(id_pesan_bedah) AS adakah FROM ri_pesan_bedah WHERE kode_ri=".$kode_ri." AND flag_pesan = 0";

		$resultset=&$db->Execute($qry);
		return $resultset->fields["adakah"];
	}
}
?>