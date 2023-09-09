<?php
include "cek-token.php";

$SqlGetKlinik="select kode_bagian,nama_bagian from mt_bagian where (validasi='0100' and kode_bagian<>'".AV_MCU."'  and kode_bagian<>'".AV_ODC."' and kode_bagian<>'".AV_ODC_VK."' and status_aktif=1 and kode_bagian not in('".AV_HEMODIALISA."','".AV_KEMOTERAPI."')) order by nama_bagian asc";
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