<?php
include "cek-token.php";

$SqlGetSpesialisasi="SELECT id_dc_agama as kode, agama as nama from dc_agama;";

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