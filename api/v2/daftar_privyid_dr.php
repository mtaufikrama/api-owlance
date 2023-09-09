<?php
include 'cek-token.php';
require_once("../../_contrib/privyid/api_sign.php");

// kode_dokter

$db->debug=true;
//----------------- Kode RS ----------------------//
$sql=read_tabel("mt_karyawan","nama_pegawai as name, nik, url_ktp_karyawan as identity, url_foto_karyawan as selfie, telp as phone, alamat, email"," where kode_dokter=$kode_dokter");
while ($tampil=$sql->FetchRow()) {
	foreach($tampil as $key=>$val){
		$$key=$val;
	}
}

$sign=new sign();
$data['reference_number']="AD-$nik";
$data['channel_id']="001";
$data['info']="randomstring";
$data['email']=$email;
$data['phone']=$phone;
$data['nik']=$nik;
$data['name']=$name;
$data['dob']=$dob;
$data['selfie']=$selfie;
$data['identity']=$identity;
$sign->debug=true;
$sign->token();
$hasil=$sign->Register($data);
if($hasil){
	$SqlGetPas="select count(no_mr) as jum from tb_privyid_reg where no_mr='$kode_dokter';";
	$RunGetPas=$db->Execute($SqlGetPas);
	while($TplGetPas=$RunGetPas->fetchRow()){
		$jum=$TplGetPas['jum'];
	}
	$DataPriv['no_mr']=$kode_dokter;
	$DataPriv['reference_number']=$hasil['data']['reference_number'];
	$DataPriv['channel_id']=$hasil['data']['channel_id'];
	$DataPriv['register_token']=$hasil['data']['register_token'];
	$DataPriv['status']=$hasil['data']['status'];
	if($jum==0){
		$result=insert_tabel("tb_privyid_reg",$DataPriv);
	}else{
		$result=update_tabel("tb_privyid_reg",$DataPriv,"where no_mr='$kode_dokter'");
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