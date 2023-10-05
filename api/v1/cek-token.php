<?php
include "../src/export.php";
// $db->debug=true;

$headers = apache_request_headers();

$authorized = $headers['authorized'];

$useRR = extrakToken($token);
// print_r($useRR);
/* -- cek akses out -- */
$KodeApi = $useRR['uid'];
$KeyApi = $useRR['uname'];
$KeyCode = $useRR['password'];
$iss = $useRR['iss'];
$SqlGetToken = "SELECT IDApi,KodeApi,KeyApi,KeyCode from login where KodeApi='$KodeApi' AND KeyApi='$KeyApi' AND KeyCode='$KeyCode'";
$RunGetToken = $db->Execute($SqlGetToken);
while ($TplGetToken = $RunGetToken->fetchRow()) {
	foreach ($TplGetToken as $key => $val) {
		$$key = $val;
	}
}
if ($IDApi < 1) {
	$Resdata['code'] = 500;
	$Resdata['msg'] = 'Akses Ditolak';
	echo json_encode($dataRes);
	die;
}
/* -- cek time out -- */
if ($useRR['exp'] < strtotime(date("Y-m-d H:i:s"))) {
	$dataRes['code'] = 500;
	$dataRes['msg'] = 'Batas waktu akses selesai, silahkan generate token ulang :)';
	echo json_encode($dataRes);
	die;
}
$dataSend = decryptData();
foreach ($dataSend as $key => $val) {
	$$key = $val;
}
foreach ($_FILES as $key => $val) {
	$$key = $val;
}
