<?php
session_start();
require_once("../_lib/function/db_login.php");
require_once("../_contrib/privyid/api_sign.php");
$sign=new sign();
$data['otp_code']=$otp_code;
$data['transaction_id']=$transaction_id;
$sign->token();
$hasil=$sign->OTPValidation($data);

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