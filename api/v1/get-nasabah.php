<?php
include "cek-token.php";

$sql = 'SELECT kode_kelompok as kode, nama_kelompok as nama FROM mt_nasabah ORDER BY kode_kelompok ASC';
$getNasabah = &$db->Execute($sql);
while($lp=$getNasabah->fetchRow()){
    $data[] = $lp;
}
if(is_array($data)){
	$datax['code']=200;
	$datax['list']=$data;
}else{
	$datax['code']=500;
	$datax['msg']="Tidak ada data ditemukan";
}
echo json_encode($datax);
?>