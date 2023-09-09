<?php
include "cek-token.php";

$data = array(
    array('kode' => 'Baik','nama' => 'Baik'),
    array('kode' => 'Sedang', 'nama' => 'Sedang'),
    array('kode' => 'Berat', 'nama' => 'Berat'),
);

if(is_array($data)){
	$datax['code']	= 200;
	$datax['list']	= $data;
}else{
	$datax['code']	= 500;
	$datax['msg']	= "Tidak ada data ditemukan";
}
echo json_encode($datax);
?>