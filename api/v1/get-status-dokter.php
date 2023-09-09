<?php
include "cek-token.php";

$data = array(
    array('id' => 0, 'nama' => 'Junior'),
    array('id' => 1, 'nama' => 'Senior'),
    array('id' => 2, 'nama' => 'Profesor'),
    array('id' => 3, 'nama' => 'Spesialis'),
    array('id' => 4, 'nama' => 'Sub Spesialis'),
    array('id' => 5, 'nama' => 'Umum'),
    array('id' => 6, 'nama' => 'Trapis')
);

if(is_array($data)){
	$datax['code']=200;
	$datax['status']=$data;
}else{
	$datax['code']=500;
	$datax['msg']="Tidak ada data ditemukan";
}
echo json_encode($datax);
?>