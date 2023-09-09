<?php
session_start();
require_once("../_lib/function/db_login.php");
require_once("../_lib/function/function.olah_tabel.php");
require_once("../_contrib/privyid/api_sign.php");

//$db->debug=true;

$SqlGetData="SELECT email,no_hp,no_ktp,nama_pasien,tgl_lhr,b.foto_selfie,b.foto_ktp from mt_master_pasien a join mt_master_pasien_img b on a.no_mr=b.no_mr where a.no_mr='$no_mr';";
$RunGetData=$db->Execute($SqlGetData);
while($TplGetData=$RunGetData->fetchRow()){
	$email=$TplGetData['email'];
	$no_hp=$TplGetData['no_hp'];
	$no_ktp=$TplGetData['no_ktp'];
	$nama_pasien=$TplGetData['nama_pasien'];
	$tgl_lhr=$TplGetData['tgl_lhr'];
	$tgl_lhr=date("Y-m-d",strtotime($tgl_lhr));	
	$foto_selfie=$TplGetData['foto_selfie'];
	$foto_ktp=$TplGetData['foto_ktp'];
}
$sign=new sign();
$data['reference_number']="test000000001";
$data['channel_id']="001";
$data['info']="randomstring";
$data['email']=$email;
$data['phone']=$no_hp;
$data['nik']=$no_ktp;
$data['name']=$nama_pasien;
$data['dob']=$tgl_lhr;
$data['selfie']=$foto_selfie;
$data['identity']=$foto_ktp;
//$sign->debug=true;
$sign->token();
$hasil=$sign->Register($data);
if($hasil){
	$SqlGetPas="select count(no_mr) as jum from tb_privyid_reg where no_mr='$no_mr';";
	$RunGetPas=$db->Execute($SqlGetPas);
	while($TplGetPas=$RunGetPas->fetchRow()){
		$jum=$TplGetPas['jum'];
	}
	$DataPriv['no_mr']=$no_mr;
	$DataPriv['reference_number']=$hasil['data']['reference_number'];
	$DataPriv['channel_id']=$hasil['data']['channel_id'];
	$DataPriv['register_token']=$hasil['data']['register_token'];
	$DataPriv['status']=$hasil['data']['status'];
	if($jum==0){
		$result=insert_tabel("tb_privyid_reg",$DataPriv);
	}else{
		$result=update_tabel("tb_privyid_reg",$DataPriv,"where no_mr='$no_mr'");
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