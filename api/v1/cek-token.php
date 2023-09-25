<?php
include "../src/export.php";
// $db->debug=true;

$headers = apache_request_headers();

if ($headers['X-Api-Token']) {
	$token = $headers['X-Api-Token']; // Nginx
} else {
	$token = $headers['x-api-token']; // Apache
}

if ($headers['MTR']){
	$q['code']=500;
	$q['msg']='Aplikasi harus update';
	echo json_encode($q);
	die;
}

$useRR=extrakToken($token);
// print_r($useRR);
/* -- cek akses out -- */
$KodeApi	=$useRR['uid'];
$KeyApi		=$useRR['uname'];
$KeyCode	=$useRR['password'];
$iss		=$useRR['iss'];
$SqlGetToken="SELECT IDApi,KodeApi,KeyApi,KeyCode from ref_api_dmedis where KodeApi='$KodeApi' AND KeyApi='$KeyApi' AND KeyCode='$KeyCode'";
$RunGetToken=$db->Execute($SqlGetToken);
while($TplGetToken=$RunGetToken->fetchRow()){
	foreach($TplGetToken as $key=>$val){
		$$key=$val;
	}
}
if($IDApi < 1){
	$Resdata['code']=500;
	$Resdata['msg']='Akses Ditolak';
	echo json_encode($dataRes);
	die;
}
/* -- cek time out -- */
if($useRR['exp']< strtotime(date("Y-m-d H:i:s"))){
	$dataRes['code']=500;
	$dataRes['msg']='Batas waktu akses selesai, silahkan generate token ulang :)';
	echo json_encode($dataRes);
	die;
}
$dataSend = json_decode(file_get_contents("php://input"),TRUE);
foreach($dataSend as $key=>$val){
	$$key=$val;
}
foreach($_FILES as $key=>$val){
	$$key=$val;
}

// include '../../var.php';

// foreach($_GET as $key=>$val){
// 	$$key=$val;
// }
?>