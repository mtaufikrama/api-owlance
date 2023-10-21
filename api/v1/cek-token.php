<?php
include "../src/export.php";
// $db->debug=true;

// $headers = apache_request_headers();
// if ($headers['Authorization']) {
// 	$authorized = $headers['Authorization'];
// } else {
// 	$authorized = $headers['authorization'];
// }

$authorized = $_GET['api_key'];

$dataRes['code'] = 300;
$dataRes['msg'] = 'Akses ditolak';

if ($authorized || $authorized != '') {
	$id_user = baca_tabel('login', 'id_user', "where token='$authorized'");
}

if ($id_user || $id_user != '') {
	$id_user = baca_tabel('user', 'id', "where id='$id_user'");
	if ($id_user || $id_user != '') {
		$update['waktu'] = date("Y-m-d H:i:s");
		$result = update_tabel('login', $update, "where token='$authorized'");
		if ($result) {
			$oneMonthAgo = date('Y-m-d H:i:s', strtotime('-1 month'));
			delete_tabel("login", "where waktu < '$oneMonthAgo'");
			unset($dataRes);
			$dataSend = decryptData();
			foreach ($dataSend as $key => $val) {
				$$key = $val;
			}
			foreach ($_FILES as $key => $val) {
				$$key = $val;
			}
		} else {
			echo encryptData($dataRes);
			die();
		}
	} else {
		echo encryptData($dataRes);
		die();
	}
} else {
	echo encryptData($dataRes);
	die();
}
