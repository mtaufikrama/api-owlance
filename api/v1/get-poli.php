<?php
include "cek-token.php";

$SqlGetKlinik="SELECT kode_bagian,nama_bagian FROM mt_bagian WHERE kode_bagian LIKE'01%' AND group_bag = 'Detail' ORDER BY nama_bagian;";
$RunGetKlinik=$db->Execute($SqlGetKlinik);

$TplGetKlinik["kode_bagian"]="";
$TplGetKlinik["nama_bagian"]="-- Semua Bagian --";
$data[]=$TplGetKlinik;

$kbg = $RunGetKlinik->Fields('kode_bagian');
while($TplGetKlinik=$RunGetKlinik->fetchRow()){
	$data[]=$TplGetKlinik;
}


if($kbg!=""){
	$datax['code']=200;
	$datax['list']=$data;
}else{
	$datax['code']=500;
	$datax['msg']="Tidak ada data ditemukan";
}
echo json_encode($datax);
?>