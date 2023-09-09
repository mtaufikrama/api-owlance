<?php

include "cek-token.php";

$Sql="SELECT id_dd_referensi as kode, nama_referensi as nama FROM dd_referensi";

$Run=$db->Execute($Sql);

while($Tpl=$Run->fetchRow()){
	$data[]=$Tpl;
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