<?php
include "cek-token.php";

$data = array(
    array('kode' => '1', 'nama' => 'Full Time'),
    array('kode' => '2', 'nama' => 'Part Time'),
    array('kode' => '3', 'nama' => 'Dokter Tamu'),
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