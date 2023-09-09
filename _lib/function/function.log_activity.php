<?

require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");
loadlib("function","function.max_kode_number");
loadlib("function","function.datetime");

// ================================================== input log activity user ===============================================
if (!function_exists("log_activity"))
{
function log_activity($array_isi_log="")
{
	
	

	global $db;
	global $loginInfo;
	global $PHP_SELF;
	
	//$db->debug=true;
	
	//inisialisasi
	unset($insertLogUserActivity);
	$insertLogUserActivity=$array_isi_log;
	//$insertLogUserActivity["id_log_user_activity"] = $id_log_user_activity;
	$insertLogUserActivity["id_dd_user"] = $loginInfo["id_dd_user"];
	$insertLogUserActivity["tgl_activity"]=date('Y-m-d H:i:s');
	$insertLogUserActivity["session_id"]=session_id();
	$insertLogUserActivity["ip_user_activity"]=USER_IP_ADDRESS;
	$insertLogUserActivity["nama_file"] = $PHP_SELF;

	if($insertLogUserActivity["kode_proses"] !="")
	{$insertLogUserActivity["nama_proses"]= baca_tabel("dd_log_proses","nama_proses","WHERE kode_proses = ".$insertLogUserActivity["kode_proses"]);}

	if(($insertLogUserActivity["no_kunjungan"] !="") && ($insertLogUserActivity["no_registrasi"] ==""))
	{$insertLogUserActivity["no_registrasi"]= baca_tabel("tc_kunjungan","no_registrasi","WHERE no_kunjungan = ".$insertLogUserActivity["no_kunjungan"]);}



		$result = true;

	$db->BeginTrans();

	//////////////////////////////////////////////////////////////////////

	

	//$insertLogUserActivity["id_log_user_activity"] = $id_log_user_activity;
	//$insertLogUserActivity["id_dd_user"] = $id_dd_user;
	//$insertLogUserActivity["tgl_activity"] = $tgl_activity;
	//$insertLogUserActivity["ip_user_activity"] = $ip_user_activity;
	//$insertLogUserActivity["nama_file"] = $nama_file;
	//$insertLogUserActivity["session_id"] = $session_id;
	//$insertLogUserActivity["nama_proses"] = $nama_proses;

	//$insertLogUserActivity["aktivitas"] = $aktivitas;
	//$insertLogUserActivity["keterangan_aktivitas"] = $keterangan_aktivitas;
	//$insertLogUserActivity["kode_bagian"] = $kode_bagian;
	//$insertLogUserActivity["no_mr"] = $no_mr;
	//$insertLogUserActivity["kode_proses"] = $kode_proses;
	
	$result = insert_tabel("log_user_activity", $insertLogUserActivity);

	//////////////////////////////////////////////////////////////////////

	$db->CommitTrans($result !== false);
	//die();

return $result;
}
}
// ====================================================================================      end of mencari nomor kunjungan

?>