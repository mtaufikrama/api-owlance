<?
// ================================================== mencari nomor kunjungan ===============================================
if (!function_exists("nama_bagian")) {
	function nama_bagian_function()
	{
	global $db;

			$sqlnya="select kode_bagian,nama_bagian from mt_bagian ";
			$res_pasien_f = &$db->Execute($sqlnya);

			while ($tampil=$res_pasien_f->FetchRow()) {
					$kode_bagian = $tampil["kode_bagian"];
					$hasil[$kode_bagian] = $tampil["nama_bagian"];
			}
			

	return $hasil;
	}
}
// ====================================================================================      end of mencari nomor kunjungan

// ================================================== pasien masuk   ===============================================
?>