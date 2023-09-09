<?php
include 'cek-token.php';
require_once("../../_contrib/privyid/api_sign.php");

// kode_dokter

// $db->debug=true;
//----------------- Kode RS ----------------------//
$sql=read_tabel("tb_privyid_reg","privyid"," where kode_dokter=$kode_dokter");
while ($tampil=$sql->FetchRow()) {
	foreach($tampil as $key=>$val){
		$$key=$val;
	}
}
	if($result){
		$datax['code']=200;
		$datax['msg']="Sukses";
		$datax['privyid']=$privyid;
		
	}else{
		$datax['code']=500;
		$datax['msg']="Gagal";
		
	}
	

echo json_encode($datax);
?>