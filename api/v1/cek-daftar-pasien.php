<?php
include "cek-token.php";

//no_mr

$cek=baca_tabel("tc_kunjungan","kode_bagian_tujuan","WHERE no_mr='$no_mr' AND DAY(tgl_masuk) =". date('d') ." AND MONTH(tgl_masuk) =". date('m') ." AND YEAR(tgl_masuk) =". date('Y')." AND tgl_keluar IS NULL"," ORDER BY id_tc_kunjungan DESC");
//$cek_bagian=baca_tabel("mt_bagian","kode_bagian,nama_bagian");
// echo $cek;
$kodeDepan=substr($cek,0,2);
$kodeBelakang=substr($cek,4,2);
//echo $kodeBelakang;
if($cek!=""){
	$data['code'] = 200;
	switch ($kodeDepan) {
		case "01":
		$nama_bagian=baca_tabel("mt_bagian","nama_bagian"," where kode_bagian='".$cek."'");
		$data['msg']="Pasien masih dalam antrian ".$nama_bagian;
		break;
		case "03":
		$data['msg']="Pasien masih dalam antrian Rawat Inap";
		break;
		case "05":
		$data['msg']="Pasien masih dalam antrian Penunjang Medis";
		break;

		default:
	}
} else {
	$data['code']=500;
	$data['msg']='Pasien Tidak Terdaftar pada Antrian Hari Ini';
}

echo json_encode($data);
?>