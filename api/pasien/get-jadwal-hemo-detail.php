<?php
include "cek-token.php";

$curentTime = date("H:i:s");
$SqlGet="select IdDaftarKlinik as idReg,nama_dokter,tgl_daftar as tgl,flag_status,flag_pemesanan,kode_rs,ket_klinik from tc_pendaftaran_hd where IdDaftarKlinik='$idReg'";
$RunGet=$db->Execute($SqlGet);
$idReg = $RunGet->Fields('idReg');
while($TplGet=$RunGet->fetchRow()){
	if($TplGet['flag_pemesanan']=="1"){
        $waktu_pesan = "Pagi";
    }else{
        $waktu_pesan = "Siang";
    }

	$arrx['idReg']          =$TplGet['idReg'];
	$arrx['nama_dokter']    =$TplGet['nama_dokter'];
    $arrx['nama_bagian']    ="Hemodialisa";
	$arrx['tgl']            =$TplGet['tgl'];
	$arrx['status']         =$TplGet['flag_status'];
	$arrx['kode_rs']        =$TplGet['kode_rs'];
	$arrx['ket_rs']         =$TplGet['ket_klinik'];
	$arrx['wkt_pesan']      =$waktu_pesan;
	$data['list'][]=$arrx;
}
if($idReg!=""){
	$data['code']=200;
}else{
	$data['code']=500;
	$data['msg']="Data tidak ditemukan";
}
echo json_encode($data);
?>