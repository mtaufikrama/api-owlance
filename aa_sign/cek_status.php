<?php
session_start();
require_once("../_lib/function/db_login.php");
require_once("../_lib/function/function.olah_tabel.php");
require_once("../_contrib/privyid/api_sign.php");
$mr=base64_decode($a);
$SqlGetData="SELECT\n".
"tb_privyid_reg.no_mr,\n".
"tb_privyid_reg.reference_number,\n".
"tb_privyid_reg.channel_id,\n".
"tb_privyid_reg.register_token,\n".
"tb_privyid_reg.`status`\n".
"FROM `tb_privyid_reg` where no_mr='$mr';";
$RunGetData=$db->Execute($SqlGetData);
while($TplGetData=$RunGetData->fetchRow()){
	$reference_number=$TplGetData['reference_number'];
	$channel_id=$TplGetData['channel_id'];
	$register_token=$TplGetData['register_token'];
	
}
$sign=new sign();
$data['reference_number']=$reference_number;
$data['channel_id']=$channel_id;
$data['info']="randomstring";
$data['register_token']=$register_token;
// $sign->debug=true;
$sign->token();
$hasil=$sign->CheckStatus($data);

if(is_array($hasil['error'])){		
		$datax['code']=500;
		$datax['msg']=$hasil['error']['errors'][0];
	}else{
		$datax['code']=200;
		$datax['msg']=$hasil;
		$UpdDtaPrivyid['privyid']=$hasil['data']['privy_id'];
		$UpdDtaPrivyid['status']=$hasil['data']['status'];
		// $db->debug=true;
		$result=update_tabel("tb_privyid_reg",$UpdDtaPrivyid,"where no_mr='$mr'");
	}
echo json_encode($datax);
?>