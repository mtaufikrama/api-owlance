<?php

include "cek-token.php";

$arr_goldarah = array('A+','A-','B+','B-','AB+','AB-','O-','O+','Belum Diperiksa');
$data['code'] = 200;
$data['list'] = $arr_goldarah;

echo json_encode($data);

?>

