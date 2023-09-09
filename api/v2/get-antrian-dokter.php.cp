<?php
include "cek-token.php";
require_once("../../_contrib/klinik/api_klinik.php");
// $db->debug=true;

foreach($src as $key=>$val){
	$$key=$val;
}

/*1.AMBIL DOKTER BAGIAN*/
/*********************************************************************************************/
$currTime=date("Y-m-d H:i:s");
$dNow=date("d");
$mNow=date("m");
$yNow=date("Y");

$no_antrian=max_kode_number("pl_tc_poli","no_antrian","WHERE YEAR(tgl_jam_poli)=".$yNow." AND MONTH(tgl_jam_poli)=".$mNow." AND DAY(tgl_jam_poli)=".$dNow." AND kode_dokter=".$kode_dokter);
/*********************************************************************************************/

$sqlBag="select jam_mulai,jam_akhir,waktu_periksa from mt_jadwal_dokter where id_mt_jadwal_dokter=$id";
$hasilBag=$db->Execute($sqlBag);

while($tampilBag=$hasilBag->FetchRow()){
	$jam_mulai=$tampilBag["jam_mulai"];
	$jam_akhir=$tampilBag["jam_akhir"];
	$waktu_periksa=$tampilBag["waktu_periksa"];
}

$ambilJadwal 			= $jam_mulai;
$ambilJadwalAkhir 		= $jam_akhir;
$ambilDurasi 			= $waktu_periksa;
$multiplier = ($no_antrian-1)*$ambilDurasi;

$jam_mulai = date("$yNow-$mNow-$dNow ").date("H:i:s",strtotime($jam_mulai));
$jam_akhir = date("$yNow-$mNow-$dNow ").date("H:i:s",strtotime($jam_akhir));
/*********************************************************************************************/
$currTime=date("Y-m-d H:i:s");
if(strtotime($currTime) < strtotime($jam_akhir)){
	if (strtotime($currTime) > strtotime($jam_akhir)) {
		$data['code']=500;
		$data['msg']="Jadwal dokter tidak tersedia";
	}else{ 
		$angka = 0;
		while(strtotime($jam_mulai) < strtotime($jam_akhir)){
			$angka++;
			// echo $currTime." | ";
			// echo $jam_mulai." | ";
			// echo $ambilDurasi." <br> ";
		
			$antrianDiambil=baca_tabel("pl_tc_poli","no_antrian"," where kode_dokter=$kode_dokter
			and no_antrian = $angka and YEAR(tgl_jam_poli)=".$yNow." AND MONTH(tgl_jam_poli)=".$mNow." AND DAY(tgl_jam_poli)=".$dNow." AND status_batal is null");
			if($antrianDiambil < 1){
				$jam_awal=date("H:i:s",strtotime($jam_mulai));
				$antrianDiambil=baca_tabel("tc_pendaftaran_klinik","no_antrian","where no_antrian='$no_antrian' AND YEAR(tgl_daftar)=$yNow AND MONTH(tgl_daftar)=$mNow AND DAY(tgl_daftar)=$dNow AND kode_dokter='$kode_dokter' AND jam_awal='$jam_awal'");
			}
			
			
			
			if(strtotime($currTime) < strtotime($jam_mulai)){
				if($antrianDiambil < $angka){
					$tampil['antrian']=$angka;
					$tampil['durasi']=$waktu_periksa;			
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
				// $jam_mulai = date("H:i:s",strtotime('+ '.$ambilDurasi.' minute',strtotime($jam_mulai)));
		}
	}
}
if(is_array($data['list'])) {
	$data['code']=200;
}else{
	$data['code']=500;
	$data['msg']="Jadwal dokter tidak tersedia";
}
echo json_encode($data);
?>