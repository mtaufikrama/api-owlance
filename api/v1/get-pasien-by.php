<?php
include "cek-token.php";

// kode_dokter

$no_induk = baca_tabel('mt_karyawan','no_induk','where kode_dokter='.$kode_dokter);

$id_dd_user = baca_tabel('dd_user','id_dd_user',"where no_induk='$no_induk'");

$SqlGetJadwalDokter="SELECT nama_pasien,tgl_lhr,no_hp,no_mr,jen_kelamin,gol_darah, url_foto_pasien as foto from mt_master_pasien where id_dd_user=$id_dd_user";

$RunGetJadwalDokter=$db->Execute($SqlGetJadwalDokter);

$no = 1;
while($TplGetJadwalDokter=$RunGetJadwalDokter->fetchRow()){
	$TplGetJadwalDokter['no'] = $no++;
	$data[] = $TplGetJadwalDokter;
}

if(is_array($data)) {
	$datax['code']	= 200;
	$datax['msg']	= 'Pasien Lama Ditemukan';
	$datax['pasien']= $data;
} else {
	$datax['code']	= 500;
	$datax['msg']	= "Tidak Ada Pasien Lama";
}
echo json_encode($datax);
?>