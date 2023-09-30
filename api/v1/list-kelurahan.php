<?php
include "cek-token.php";

//id_kecamatan

if ($id_kecamatan == '') {
	$datax['code']=500;
	$datax['msg']="ID Kecamatan tidak ada";
	echo json_encode($datax);
	die();
}

$SqlGetSpesialisasi="SELECT id_dc_kelurahan as id, nama_kelurahan as kelurahan, kode_pos from kelurahan where id_dc_kecamatan=$id_kecamatan;";

$RunGetSpesialisasi=$db->Execute($SqlGetSpesialisasi);

while($TplGetSpesialisasi=$RunGetSpesialisasi->fetchRow()){
	$data[]=$TplGetSpesialisasi;
}

if(is_array($data)){
	$datax['code']=200;
	$datax['kelurahan']=$data;
}else{
	$datax['code']=500;
	$datax['msg']="Tidak ada data ditemukan";
}
echo json_encode($datax);
?>