<?php
session_start();
require_once("../_lib/function/db_login.php");
require_once("../_contrib/privyid/api_sign.php");
$mr=base64_decode($a);
$SqlGetData="SELECT\n".
"tb_privyid_reg.no_mr,\n".
"tb_privyid_reg.reference_number,\n".
"tb_privyid_reg.channel_id,\n".
"tb_privyid_reg.register_token,\n".
"tb_privyid_reg.privyid,\n".
"tb_privyid_reg.enterpriseToken,\n".
"tb_privyid_reg.`status`\n".
"FROM `tb_privyid_reg` where no_mr='$mr';";
$RunGetData=$db->Execute($SqlGetData);
while($TplGetData=$RunGetData->fetchRow()){
	$reference_number=$TplGetData['reference_number'];
	$channel_id=$TplGetData['channel_id'];
	$register_token=$TplGetData['register_token'];
	$privyid=$TplGetData['privyid'];
	$enterpriseToken=$TplGetData['enterpriseToken'];	
}
$sign=new sign();
$data['reference_number']=$reference_number;
$data['channel_id']=$channel_id;
$data['info']="randomstring";
$data['otp_type']="0";
$data['token']=$enterpriseToken;
$data['otp_channel']="0";
$data['privy_id']=$privyid;
$sign->token();
$hasil=$sign->OTPRequest($data);

if(is_array($hasil['error'])){		
		$feedback['code']=500;
		$feedback['msg']=$hasil['error']['errors'][0];
	}else{
		$feedback['code']=200;
		$feedback['msg']=$hasil['message'];
	}
echo json_encode($feedback);
?>
?>