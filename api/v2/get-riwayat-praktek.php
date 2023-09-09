<?php
include "cek-token.php";

$SqlGetJadwalDokter="SELECT a.*, b.nama_propinsi as provinsi, c.nama_kota as kota FROM mt_dokter_detail as a left JOIN dc_propinsi as b ON b.id_dc_propinsi = a.id_dc_propinsi left JOIN dc_kota as c ON c.id_dc_kota = a.id_dc_kota where a.kode_dokter=$kode_dokter";

$RunGetJadwalDokter=$db->Execute($SqlGetJadwalDokter);
while($TplGetJadwalDokter=$RunGetJadwalDokter->fetchRow()){
	$no++;
	$jadwal['no'] = $no;
	$jadwal['kode_dokter']=round($TplGetJadwalDokter['kode_dokter']);
	$jadwal['no_izin_praktek']=round($TplGetJadwalDokter['no_izin_praktek']);
	$jadwal['status']=round($TplGetJadwalDokter['status_dokter']);
	switch ($TplGetJadwalDokter['status_dokter']){
		case "0":
			$jadwal['nama_status'] = "Junior";
			break;
		case "1":
			$jadwal['nama_status'] = "Senior";
			break;
		case "2":
			$jadwal['nama_status'] = "Profesor";
			break;
		case "3":
			$jadwal['nama_status'] = "Spesialis";
			break;
		case "4":
			$jadwal['nama_status'] = "Sub Spesialis";
			break;
		case "5":
			$jadwal['nama_status'] = "Umum";
			break;
		case "6":
			$jadwal['nama_status'] = "Terapis";
			break;
	}
	$jadwal['provinsi']=$TplGetJadwalDokter['provinsi'];
	$jadwal['kota']=$TplGetJadwalDokter['kota'];
	
	$data[] = $jadwal;
}

if(is_array($data)) {
	$datax['code']=200;
	$datax['msg']='Riwayat Praktek Dokter Ditemukan';
	$datax['riwayat_praktek']=$data;
} else {
	$datax['code']=500;
	$datax['msg']="Tidak Ada Riwayat Praktek";
}
echo json_encode($datax);
?>