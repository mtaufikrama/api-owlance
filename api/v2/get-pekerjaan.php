<?php
include "cek-token.php";

$Sql="SELECT id_dc_pekerjaan as kode, pekerjaan as nama from dc_pekerjaan;";

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