<?php
include "cek-token.php";
require_once("../../_contrib/klinik/api_klinik.php");
// $db->debug=true;

foreach($src as $key=>$val){
	$$key=$val;
}

include '../../var.php';

//----------------------------------------------------------------------------------------------//
$TglSkrg=date("Y-m-d");
if(strtotime($tgl_daftar) < strtotime($TglSkrg)){
	$data['code']=500;
	$data['msg']="";
	echo json_encode($data);
	die;
}

$tgl = date('Y-m-d',strtotime($tgl_daftar));

$CekAbsen=$db->Execute("SELECT * from tc_absen_dokter where '$tgl' BETWEEN tgl_awal AND tgl_akhir AND kode_dokter='$kode_dokter'");
if($CekAbsen->fields('IdAbsen') > 0){
	$data['code'] = 500;
	$data['msg']  = "Dokter Absen dari Tgl ".date("d-m-Y",strtotime($CekAbsen->fields('tgl_awal')))." s/d Tgl ".date("d-m-Y",strtotime($CekAbsen->fields('tgl_akhir')));
	echo json_encode($data);
	die;
}
//----------------------------------------------------------------------------------------------//

$currTime=$tgl_daftar.date("H:i:s");
$dNow=date("d",strtotime($tgl_daftar));
$mNow=date("m",strtotime($tgl_daftar));
$yNow=date("Y",strtotime($tgl_daftar));


$kode=$_GET['kode_dokter'];
$pasien=$_GET['no_mr'];
$no_registrasi=max_kode_number("tc_registrasi","no_registrasi");


/****************************************************************/

$tanggal = $tgl_daftar;
$day = date('D', strtotime($tanggal));
$dayList = array(
					'Sun' => 'Minggu',
					'Mon' => 'Senin',
					'Tue' => 'Selasa',
					'Wed' => 'Rabu',
					'Thu' => 'Kamis',
					'Fri' => 'Jumat',
					'Sat' => 'Sabtu'
);
 
if($day == "Sun"){
	
	$sqlHari=" and minggu=1";
	
}else if($day == "Mon"){
	
	$sqlHari=" and senin=1";
	
}else if($day == "Tue"){
	
	$sqlHari=" and selasa=1";
	
}else if($day == "Wed"){
	
	$sqlHari=" and rabu=1";
	
}else if($day == "Thu"){
	
	$sqlHari=" and kamis=1";
	
}else if($day == "Fri"){
	
	$sqlHari=" and jumat=1";
	
}else if($day == "Sat"){
	
	$sqlHari=" and sabtu=1";
	
}
/****************************************************************/


$sqlJadwal = "SELECT * FROM mt_jadwal_dokter WHERE id_mt_jadwal_dokter = $id_jadwal $sqlHari";
$hasilJadwal = $db->Execute($sqlJadwal);

$ambilJadwal = $hasilJadwal->Fields('jam_mulai');
$ambilJadwalAkhir = $hasilJadwal->Fields('jam_akhir');
$ambilDurasi = $hasilJadwal->Fields('waktu_periksa');
if($ambilDurasi < 1){
	$data['code']=500;
	$data['msg']="Jadwal dokter tidak tersedia";
	echo json_encode($data);
	die;
}
$jam_mulai = date("H:i:s",strtotime($ambilJadwal));
$jam_akhir = date("H:i:s",strtotime($ambilJadwalAkhir));
$jam_sekarang=date("H:i:s");

if(strtotime($tgl_daftar) == strtotime(date("Y-m-d"))){
	if(strtotime($jam_mulai)<strtotime($jam_sekarang)){
		$jeda=strtotime(date("Y-m-d H:i:s")) - strtotime(date("H:i:s",strtotime($jam_mulai)));// Jam Sekarang - Jam Mulai
		
		$jeda=ceil($jeda/($ambilDurasi*60));
		$jam_mulai=strtotime($ambilJadwal) + ($jeda * $ambilDurasi * 60);
		$jam_mulai = date("H:i:s",$jam_mulai);
		
		$angka =$jeda;
	}else{
		$angka=0;
	}
	
	
}else{
	$angka=0;
}

$kode_dokter = baca_tabel('mt_jadwal_dokter','kode_dokter',"where id_mt_jadwal_dokter='$id_jadwal'");

$angka=$angka;
while(strtotime($jam_mulai) < strtotime($jam_akhir)){
	$angka++;
	$antrianDiambil=baca_tabel("tc_pendaftaran_klinik","no_antrian"," where kode_dokter=$kode_dokter
	and no_antrian = $angka and YEAR(tgl_daftar)=".$yNow." AND MONTH(tgl_daftar)=".$mNow." AND DAY(tgl_daftar)=".$dNow." and (flag_status is null or flag_status=99)");									
	if($antrianDiambil!=$angka){
		 $antrianDiambil =baca_tabel("pl_tc_poli","no_antrian"," where kode_dokter=$kode_dokter
	and no_antrian = $angka and YEAR(tgl_jam_poli)=".$yNow." AND MONTH(tgl_jam_poli)=".$mNow." AND DAY(tgl_jam_poli)=".$dNow."");
	}
	//tambahan musa
	if($antrianDiambil < $angka){
		$tampil['antrian']=$angka;
		$tampil['durasi']=$ambilDurasi;			
		$tampil['jam']=date("H:i:s",strtotime($jam_mulai));			
		$jam_mulai = date("H:i:s",strtotime('+ '.$ambilDurasi.' minute',strtotime($jam_mulai)));
		if($antrianDiambil==$angka){
			$data['code']=500;
			$data['msg']="Jadwal dokter tidak tersedia";
		}else{
			$data['list'][]=$tampil;
		}
	}else{
		$jam_mulai = date("H:i:s",strtotime('+ '.$ambilDurasi.' minute',strtotime($jam_mulai)));
	}
}
								
								
//----------------------------------------------------------------------------------------------//
if(is_array($data['list'])) {
	$data['code']=200;
}else{
	$data['code']=500;
	$data['msg']="Jadwal dokter tidak tersedia";
}
echo json_encode($data);
?>