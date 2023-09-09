<?php

include "cek-token.php";
$no_mr=baca_tabel("tbl_pasien","nama_pasien","where no_ktp='$no_ktp'");
// echo $no_mr;
if(mb_strlen($no_mr)<1){
	$data['code']=500;
	$data['msg']="Data pasien tidak kami temukan";
	echo json_encode($data);
	
}else{
	$data['code']=200;
	$data['msg']="Data pasien ditemukan";
	echo json_encode($data);
}

?>