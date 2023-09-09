<?php
include "cek-token.php";

$data = array(
    array('id' => 1, 'nama' => 'Full Time'),
    array('id' => 2, 'nama' => 'Part Time'),
    array('id' => 3, 'nama' => 'Dokter Tamu'),
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