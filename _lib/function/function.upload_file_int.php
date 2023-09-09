<?
function upload_file_int($nama_var="",$nama_file_asli="",$alamat="../interface/temp/") {

	global $realname;

	if (is_uploaded_file($_FILES[$nama_var]['tmp_name'])) {
		$filename = $_FILES[$nama_var]['tmp_name'];

		if((string)$nama_file_asli==""):
			$realname = $_FILES[$nama_var]['name'];
		else:
			$realname = $nama_file_asli;
		endif;
		//echo $alamat.$realname;
		$retval = copy($_FILES[$nama_var]['tmp_name'],$alamat.$realname);
	} else {
		$retval = false;
	}
	return $retval;
}
?>