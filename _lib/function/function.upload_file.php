<?
function upload_file($nama_var="",$nama_file_asli="",$alamat="../interface/temp/") {

	global $realname;

	if (is_uploaded_file($_FILES[$nama_var]['tmp_name'])) {
		$filename = $_FILES[$nama_var]['tmp_name'];
		$hasil="File berhasil diupload !<br>";

		if($nama_file_asli==""):
			$realname = $_FILES[$nama_var]['name'];
		else:
			$realname = $nama_file_asli;
		endif;
		//print "realname is $realname";

		//print "copying file to uploads dir";

		$retval = copy($_FILES[$nama_var]['tmp_name'],$alamat.$realname);
		$hasil.="File $realname berhasil dicopy ke $alamat !<br>";
	} else {
		$hasil = "UPLOAD FILE : ".$_FILES[$nama_var]['name']." GAGAL !.<BR>";
	}
	return $hasil;
}
?>