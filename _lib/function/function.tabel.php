<?
// ----------------------- FUNCTION column_names -----------------------

/**
 * column_names() : Untuk mengambil nama kolom dari suatu tabel, return false kalo parameter $tblname null
 *
 * @param string $tblname Nama tabel
 *
 * @return mixed
 *
 */

if (!function_exists("column_names")) {
	function column_names($tblname="") {
		global $db;
		if (strlen($tblname)>0) {
			return $db->MetaColumnNames($tblname);
		} else {
			return FALSE;
		} // end of if(strlen($tblname)>0)
	} // end of function column_names($tblname="")
} // end of if(!function_exists("column_names"))

// ----------------------- FUNCTION check_mysql -----------------------

/**
 * check_mysql() : Untuk mendeteksi kesalahan pada database tipe MySQL
 *
 * @param boolean $kode memunculkan error code yang di-generate oleh mysql
 *
 * @return mixed
 *
 */

if (!function_exists("check_mysql")) {
	function check_mysql($kode = false) {
		if (!$kode) {
			if (mysql_errno() == 0)
				$txt_pesan = "Data berhasil diperbaharui";
			else
				$txt_pesan = "Data tidak berhasil diperbaharui";
			return $txt_pesan;
		} else
			return mysql_errno();
	} // end of function check_mysql($kode = false)
} // end of if(!function_exists("check_mysql"))

// ----------------------- FUNCTION  -----------------------

/**
 * nama_fungsi() : Keterangan fungsinya
 *
 * @param tipe_variabel $nama_variabel Keterangan variabelnya
 *
 * @return tipe_variabel
 *
 */


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------


// ----------------------- FUNCTION  -----------------------

?>