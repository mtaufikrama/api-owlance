<?php
ini_set('max_execution_time', '0');
include "../../_lib/function/db_login.php";
include "../src/jwt.php";
include "../../_lib/function/function.olah_tabel.php";
// $db->debug=true;
$data = json_decode(file_get_contents("php://input"),TRUE);
// print_r($data);
$KodeApi	=$data['KodeApi'];
$KeyApi		=$data['KeyApi'];
$KeyCode	=$data['KeyCode'];

$SqlGetToken="select IDApi,KodeApi,KeyApi,KeyCode from ref_api_dmedis where KodeApi='$KodeApi' AND KeyApi='$KeyApi' AND KeyCode='$KeyCode'";
$RunGetToken=$db->Execute($SqlGetToken);
while($TplGetToken=$RunGetToken->fetchRow()){
	foreach($TplGetToken as $key=>$val){
		$$key=$val;
	}
}
if($IDApi > 0){
	$token=getLoginToken($KodeApi,$KeyApi,$KeyCode);
	$Resdata['code']=200;
	$Resdata['token']=$token;
}else{
	$Resdata['code']=500;
	$Resdata['msg']='Akses Ditolak';
}


echo json_encode($Resdata);
?>