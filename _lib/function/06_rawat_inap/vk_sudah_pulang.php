<?
if (!function_exists("vk_sudah_pulang")) {
	function vk_sudah_pulang($kode_ri) {
		global $db;

		$qry = "SELECT COUNT(id_pasien_vk) AS adakah FROM ri_pasien_vk WHERE kode_ri=".$kode_ri." AND flag_vk = 0";

		$resultset=&$db->Execute($qry);
		return $resultset->fields["adakah"];
	}
}
?>