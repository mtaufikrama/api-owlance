<?php
include 'cek-no-token.php';

if ($IDApi > 0) {
	$token = getLoginToken($KodeApi, $KeyApi, $KeyCode);
	$Resdata['code'] = 200;
	$Resdata['token'] = $token;
} else {
	$Resdata['code'] = 500;
	$Resdata['msg'] = 'Akses Ditolak';
}

echo encryptData($Resdata);