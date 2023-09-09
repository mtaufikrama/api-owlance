<?php
include "cek-token.php";

$SqlGet="SELECT IdDaftarKlinik as idReg,no_antrian,nama_dokter,tgl_daftar as tgl,jam_awal,jam_akhir,flag_status as `status`,nama_klinik,nama_bagian,ket_klinik from tc_pendaftaran_klinik where no_ktp='$no_ktp' and flag_status is null";
$RunGet=$db->Execute($SqlGet);
$idReg = $RunGet->Fields('idReg');

while($TplGet=$RunGet->fetchRow()){
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