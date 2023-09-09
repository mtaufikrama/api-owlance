<?php
session_start();
require_once("../_lib/function/db_login.php");
require_once("../_lib/function/function.olah_tabel.php");
require_once("../_contrib/privyid/api_sign.php");
//----------------- Kode RS ----------------------//
$SqlGetKodeRS="select kode_rs from dd_konfigurasi;";
$RunGetKodeRS=$db->Execute($SqlGetKodeRS);
while($TplGetKodeRS=$RunGetKodeRS->fetchRow()){
	$kode_rs=$TplGetKodeRS['kode_rs'];
}
//----------------- Kode RS ----------------------//

//$db->debug=true;
$tglSkrg=date("Ymd");
$sign=new sign();
$data['reference_number']="AV-$tglSkrg-$kode_rs-$mr";
$data['channel_id']="001";
$data['info']="randomstring";
$data['email']=$email;
$data['phone']=$phone;
$data['nik']=$nik;
$data['name']=$name;
$data['dob']=$dob;
$data['selfie']=$selfie;
$data['identity']=$identity;
// $sign->debug=true;
$sign->token();
$hasil=$sign->Register($data);
if($hasil){
	$SqlGetPas="select count(no_mr) as jum from tb_privyid_reg where no_mr='$mr';";
	$RunGetPas=$db->Execute($SqlGetPas);
	while($TplGetPas=$RunGetPas->fetchRow()){
		$jum=$TplGetPas['jum'];
	}
	$DataPriv['no_mr']=$mr;
	$DataPriv['reference_number']=$hasil['data']['reference_number'];
	$DataPriv['channel_id']=$hasil['data']['channel_id'];
	$DataPriv['register_token']=$hasil['data']['register_token'];
	$DataPriv['status']=$hasil['data']['status'];
	if($jum==0){
		$result=insert_tabel("tb_privyid_reg",$DataPriv);
	}else{
		$result=update_tabel("tb_privyid_reg",$DataPriv,"where no_mr='$mr'");
	}
	$db->CommitTrans($result !== false);
	if($result){
		$datax['code']=200;
		$datax['msg']=$hasil['message'];
		
	}else{
		$datax['code']=500;
		$datax['msg']=$hasil['error']['errors'][0]['param']." ".$hasil['error']['errors'][0]['messages'][0];
		
	}
	
}
echo json_encode($datax);
?>