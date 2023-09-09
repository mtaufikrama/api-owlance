<?php
include "cek-token.php";

$req = json_decode(file_get_contents("php://input"),TRUE);

$kode_dokter=$req['kode_dokter'];

$SqlGetJadwalDokter="SELECT kode_dokter,id_mt_jadwal_dokter,range_hari,jam_mulai,jam_akhir,waktu_periksa FROM mt_jadwal_dokter WHERE kode_dokter=$kode_dokter";

$RunGetJadwalDokter=$db->Execute($SqlGetJadwalDokter);
while($TplGetJadwalDokter=$RunGetJadwalDokter->fetchRow()){
	$no++;
	$jadwal['no'] 			= $no;
	$jadwal['id']			= round($TplGetJadwalDokter['id_mt_jadwal_dokter']);
	$jadwal['kode_dokter']	= round($TplGetJadwalDokter['kode_dokter']);
	$jadwal['range_hari']	= $TplGetJadwalDokter['range_hari'];
	$jadwal['jam_mulai']	= substr($TplGetJadwalDokter['jam_mulai'], 11);
	$jadwal['jam_akhir']	= substr($TplGetJadwalDokter['jam_akhir'], 11);
	$jadwal['waktu']		= round($TplGetJadwalDokter['waktu_periksa']);
	$data[] 				= $jadwal;
}

if(is_array($data)) {
	$datax['code']	=200;
	$datax['msg']	='Jadwal Dokter Ditemukan';
	$datax['jadwal']=$data;
} else {
	$datax['code']	=500;
	$datax['msg']	="Tidak Ada Jadwal Dokter";
}
echo json_encode($datax);
?>