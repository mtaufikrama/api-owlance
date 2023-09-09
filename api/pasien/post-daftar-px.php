<?php
include "cek-token.php";
require_once("../../_contrib/klinik/api_klinik.php");
// $db->debug =true;
//CEK SUDAH DAFTAR BELUM
$jam_awal=$jadwal;
$dataSend['jam_awal']=$jam_awal;
$dataSend['kode_rs']=$kode_klinik;
$jam_akhir=date("H:i",strtotime("+$durasi minutes",strtotime($jam_awal)));
$dataSend['jam_akhir']=$jam_akhir;
$SqlPxDaftar="select IdDaftarKlinik,nama_bagian,nama_klinik,no_antrian,jam_awal,nama_dokter from tc_pendaftaran_klinik where tgl_daftar ='$tgl_daftar' AND no_ktp='$no_ktp' AND flag_status is null";
$RunPxDaftar=$db->Execute($SqlPxDaftar);
while($TplPxDaftar=$RunPxDaftar->fetchRow()){
	foreach($TplPxDaftar as $key=>$val){
		$$key=$val;
	}
}
/* --- SQL GET LENGKAP --- */
$SqlGetLengkap="select tgl_lhr,almt_ttp_pasien,no_hp,email,jen_kelamin from tbl_pasien where no_ktp='$no_ktp'";
$RunGetLengkap=$db->Execute($SqlGetLengkap);
while($TplGetLengkap=$RunGetLengkap->fetchRow()){
		foreach($TplGetLengkap as $key=>$val){
			$dataSend[$key]=$val;
		}
}
/* --- SQL GET LENGKAP --- */
if($IdDaftarKlinik > 0){
	$DataRes['code']=500;
	$DataRes['msg']="Pasien sudah terdaftar di $nama_klinik $nama_bagian $nama_dokter pada jam $jam_awal no antrian $no_antrian";
	echo json_encode($DataRes);
	die;
}
// die;
$year=date("Y",strtotime($tgl_daftar));
$month=date("m",strtotime($tgl_daftar));
$day=date("d",strtotime($tgl_daftar));
$result=baca_tabel("tc_pendaftaran_klinik","no_antrian","where no_antrian='$no_antrian' AND  tgl_daftar !=$tgl_daftar AND kode_dokter='$kode_dokter' AND jam_awal='$jam_awal' AND flag_status <> 99");

if(!$result) $result=baca_tabel("pl_tc_poli","no_antrian","where no_antrian='$no_antrian' AND YEAR(tgl_jam_poli)=$year AND MONTH(tgl_jam_poli)=$month AND DAY(tgl_jam_poli)=$day AND kode_dokter='$kode_dokter'");
if(!$result)
{	
	$result = insert_tabel("tc_pendaftaran_klinik",$dataSend);
	$IdDaftarKlinik=$db->Insert_ID();
	if($result){
		$data['code']=200;
		$data['idReg']=$IdDaftarKlinik;
		$data['tgl']=$tgl_daftar;
		$data['jam_awal']=$jam_awal;
		$data['jam_akhir']=$jam_akhir;
		$data['msg']="Sukses Melakukan Perjanjian Dokter, Silahkan datang Ke RS untuk Melakukan Verifikasi Baik Lewat FO atau QRCode";
	}else{
		$data['code']=500;
		$data['msg']="Gagal Melakukan Pendaftaran di Site";
	}
}else{
	$data['code']=501;
	$data['msg']="Jadwal Sudah diambil Silahkan Pilih Ulang";
}
echo json_encode($data);
?>