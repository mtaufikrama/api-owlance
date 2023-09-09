<?php
session_start();
require_once("../_lib/function/db_login.php");
require_once("../_contrib/privyid/api_sign.php");
$mr=base64_decode($a);
$SqlGetData="SELECT\n".
"tb_privyid_reg.privy_id,\n".
"tb_privyid_reg.channel_id\n".
"FROM `tb_privyid_reg` where no_mr='$mr';";
$RunGetData=$db->Execute($SqlGetData);
while($TplGetData=$RunGetData->fetchRow()){
	$privy_id=$TplGetData['privy_id'];
}
$sign=new sign();
$data['privy_id']=$privy_id;
$data['image']="base64_img";
$sign->token();
$hasil=$sign->SetImagesignature($data);

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