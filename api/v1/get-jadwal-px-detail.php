<?php
include "cek-token.php";
$year	=date("Y",strtotime($tgl));
$month	=date("m",strtotime($tgl));
$day	=date("d",strtotime($tgl));
$curentTime = date("H:i:s");
$SqlGet="select IdDaftarKlinik as idReg,no_antrian,nama_dokter,tgl_daftar as tgl,jam_awal,jam_akhir,flag_status as `status`,nama_klinik,nama_bagian,ket_klinik from tc_pendaftaran_klinik where IdDaftarKlinik='$idReg'";
$RunGet=$db->Execute($SqlGet);
$idReg = $RunGet->Fields('idReg');
while($TplGet=$RunGet->fetchRow()){
	$jam_periksa = $TplGet['jam_awal'];
	if($curentTime > $jam_periksa){
		$TplGet['stat_jam'] = "1";
	}else{
		$TplGet['stat_jam'] = "0";
	}
	$arrx[]=$TplGet;
}
if($idReg!=""){
	$data['code']=200;
	$data['list']=$arrx;
}else{
	$data['code']=500;
	$data['msg']="Data tidak ditemukan";
}
echo json_encode($data);
?>