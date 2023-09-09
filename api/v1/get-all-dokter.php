<?php
include 'cek-token.php';

$SqlGetAllDokter="SELECT no_induk, kode_dokter, nama_pegawai, email, kode_spesialisasi, url_foto_karyawan as foto, kode_bagian, telp, url_ktp_karyawan from mt_karyawan WHERE kode_dokter is not null";

$RunGetAllDokter=$db->Execute($SqlGetAllDokter);
while($TplGetAllDokter=$RunGetAllDokter->fetchRow()){
	$data[] = $TplGetAllDokter;
}

if(is_array($data)) {
	$datax['code']=200;
	$datax['msg']='Dokter Ditemukan';
	$datax['dokter']=$data;
} else {
	$datax['code']=500;
	$datax['msg']="Tidak Ada Dokter";
}
echo json_encode($datax);
?>