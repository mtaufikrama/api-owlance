<?php
$s = date('s');
$S = baca_tabel('dd_tanggal','waktu');
$z = baca_tabel('dd_tanggal', 'msg');
$Z = baca_tabel('dc_pesan','msg',"where (email='$User' or email='$email')");
if ($S && $s < $S) {
	if ($Z){
		$data['code']=500;
		$data['msg']=$Z;
	} else {
		$data['code']=500;
		$data['msg']=$z;
	}
	echo json_encode($data);
	die;
}
?>