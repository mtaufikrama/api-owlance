<?php
include "cek-token.php";
// $db->debug=true;
// print_r($dataSend);
if ($idProv == "") {
	$SqlGetKota="select ID_DC_KOTA,NAMA_KOTA from dc_kota where ID_DC_KOTA in (select ID_DC_KOTA from mt_perusahaan where ID_DC_KOTA is not null);";
}else{	
	$SqlGetKota="select ID_DC_KOTA,NAMA_KOTA from dc_kota where ID_DC_PROPINSI='$idProv' AND ID_DC_KOTA in (select ID_DC_KOTA from mt_perusahaan where ID_DC_KOTA is not null);";
}	

$RunGetKota=$db->Execute($SqlGetKota);
$IDkota = $RunGetKota->Fields('ID_DC_KOTA');
if($IDkota!=""){
	while($TplGetKota=$RunGetKota->fetchRow()){
		$data['idKota']=$TplGetKota['ID_DC_KOTA'];
		$data['nama']=$TplGetKota['NAMA_KOTA'];
		$json[]=$data;
	}
}else{
	$data['code']=500;
	$data['msg']="data tidak ditemukan";
	$json[]=$data;
}
echo json_encode($json);
?>