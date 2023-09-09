<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once("../_lib/function/db_login.php");
require_once("../_contrib/privyid/api_sign.php");
$db->debug=true;
$SqlGetData="SELECT\n".
"tb_privyid_reg.no_mr,\n".
"tb_privyid_reg.reference_number,\n".
"tb_privyid_reg.channel_id,\n".
"tb_privyid_reg.register_token,\n".
"tb_privyid_reg.`status`\n".
"FROM `tb_privyid_reg` where no_mr='2202-0000004';";
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
//$data['register_token']=$register_token;
$sign->debug=true;
$sign->token();
$hasil=$sign->CheckStatus($data);
print_r($hasil);
?>