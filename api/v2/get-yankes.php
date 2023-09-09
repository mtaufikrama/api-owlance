<?php
include "cek-token.php";

$SqlGetSpesialisasi="SELECT kode_perusahaan as kode, nama_perusahaan as nama FROM mt_perusahaan ORDER BY nama_perusahaan ASC;";

$RunGetSpesialisasi=$db->Execute($SqlGetSpesialisasi);

while($TplGetSpesialisasi=$RunGetSpesialisasi->fetchRow()){
	$data[]=$TplGetSpesialisasi;
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