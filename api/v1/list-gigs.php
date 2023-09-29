<?php
include "cek-token.php";

// username

$SqlGetSpesialisasi="SELECT ";

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