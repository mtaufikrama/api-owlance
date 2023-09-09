<?php
include "cek-token.php";
require_once("../../_contrib/klinik/api_klinik.php");
// $db->debug =true;
//CEK SUDAH DAFTAR BELUM
$dataSend['no_ktp']=$no_ktp;
$dataSend['nama_pasien']=$nama_pasien;
$dataSend['flag_pemesanan']=$flag_pesan;
$dataSend['kode_rs']=$kode_rs;
$dataSend['kode_dokter']=$kode_dokter;
$dataSend['nama_dokter']=$nama_dokter;
$dataSend['tgl_daftar']=$tgl_daftar;

$no_mr_px=baca_tabel("mt_master_pasien","no_mr","where no_ktp='$no_ktp'");

//Cek Jenis Pasien
if($jenis_px==1){
	$dataSend['kode_kelompok'] = "1";

}else if($jenis_px==2){
	$dataSend['kode_kelompok'] = "2";
	$dataSend['kode_perusahaan'] = $kd_asuransi;

}else if($jenis_px==3){
	$dataSend['kode_kelompok'] = "3";
	$dataSend["no_bpjs"]			=$kolom1;
	$dataSend["jenis_kunjungan"]	=$jns_kunj_bpjs;
	
	if($jns_kunj_bpjs == '1'){
		$dataSend["no_rujukan"]			=$kolom2;
	}else{
		$dataSend["no_surat_kontrol"]	=$kolom2;
	}	
}else if($jenis_px==4){
	$dataSend['kode_kelompok'] = "4";
}

//Cek PX Lama
if($px_lama==1){
	$dataSend['jns_pasien'] = "Baru";
}else if($px_lama==2){
	if($no_mr_px){
		$dataSend['jns_pasien'] = "Lama";
		$dataSend['no_mr'] = $nomr_px;
	}else{
		$data['code'] = 300;
		$data['msg'] = "Anda belum terdaftar sebagai Pasien Lama pada Rumah Sakit ini, Silahkan datang ke FO untuk konfirmasi daftar ulang";
		die();
	}
}

$SqlPxDaftar="select IdDaftarKlinik,no_ktp,tgl_daftar,flag_pemesanan from tc_pendaftaran_hd where tgl_daftar ='$tgl_daftar' AND no_ktp='$no_ktp' AND flag_status is null";
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

    if($flag_pesan="1"){
        $wkt_pesan = "Pagi";
    }else if($flag_pesan="2"){
        $wkt_pesan = "Siang";
    }
	
    $dateasli = strtotime($tgl_daftar);
    $date_konvert = date('d/M/Y', $dateasli);
	$DataRes['code']=500;
	$DataRes['msg']="Pasien sudah terdaftar dalam antrian Hemodialisa pada tgl $date_konvert pada waktu $wkt_pesan";
	echo json_encode($DataRes);
	die;
}
// die;
$year=date("Y",strtotime($tgl_daftar));
$month=date("m",strtotime($tgl_daftar));
$day=date("d",strtotime($tgl_daftar));
$result=baca_tabel("tc_pendaftaran_hd","no_ktp","where flag_pemesanan is null AND tgl_daftar !=$tgl_daftar AND flag_status <> 99");

if(!$result)
{	
	$result = insert_tabel("tc_pendaftaran_hd",$dataSend);
	$IdDaftarKlinik=$db->Insert_ID();
	if($result){
		$data['code']=200;
		$data['idReg']=$IdDaftarKlinik;
		$data['tgl']=$tgl_daftar;
		$data['msg']="Sukses Melakukan Booking Hemodialisa, Silahkan datang Ke RS untuk Konfirmasi kehadiran pada FO";
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