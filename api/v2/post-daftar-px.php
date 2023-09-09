<?php
include "cek-token.php";
require_once("../../_contrib/klinik/api_klinik.php");
// $db->debug =true;
//CEK SUDAH DAFTAR BELUM

//kode_dokter, jam_awal, no_mr, durasi, nasabah, no_polis, no_bpjs, yankes, jadwal

$input = json_decode(file_get_contents("php://input"),true);
$kode_dokter              	= $input['kode_dokter'];
$no_mr              		= $input['no_mr'];
$jam_awal              		= $input['jam_awal'];
$durasi              		= $input['durasi'];
$nasabah              		= $input['nasabah'];
$no_polis              		= $input['no_polis'];
$no_bpjs              		= $input['no_bpjs'];
$yankes              		= $input['yankes'];
$jadwal              		= $input['jadwal'];

$dNow=date("d");
$mNow=date("m");
$yNow=date("Y");
$HarIni=date("Y-m-d ").$jam_awal;
$interval=($jadwal-1)*$durasi;
$jam_awal = date($HarIni,strtotime('+ '.$interval.' minute',strtotime($jam_awal)));
echo "testing $jam_awal - $HarIni - $interval";
die();
if($nasabah=="2"){
	$no_bpjs="";
}else if($nasabah=="3"){
	$yankes="";
	$no_polis="";
}else if($nasabah=="4"){
	$no_bpjs="";
	$yankes="";
	$no_polis="";
}else{
	$no_bpjs="";
	$yankes="";
	$no_polis="";
}

$no_registrasi=max_kode_number("tc_registrasi","no_registrasi");
$no_kunjungan=max_kode_number("tc_kunjungan","no_kunjungan");
$kode_poli=max_kode_number("pl_tc_poli","kode_poli");

$sqlDokter="SELECT * FROM mt_karyawan WHERE kode_dokter = $kode_dokter";
$getSqlDokter=$db->Execute($sqlDokter);
while ($showSqlDokter=$getSqlDokter->fetchRow()){
	$kode_bagian = $showSqlDokter['kode_bagian'];
}

$sqlPasien="SELECT * FROM mt_master_pasien WHERE no_mr = '$no_mr'";
$getSqlPasien=$db->Execute($sqlPasien);
while ($showSqlPasien=$getSqlPasien->fetchRow()){
	$no_mr = $showSqlPasien['no_mr'];
	$nama_pasien = $showSqlPasien['nama_pasien'];
	$nasabah = $showSqlPasien['kode_kelompok'];
	$kode_perusahaan = $showSqlPasien['kode_perusahaan'];
	$umur_pasien = $showSqlPasien['umur_pasien'];
}
// $no_antrian=max_kode_number("pl_tc_poli","no_antrian","WHERE YEAR(tgl_jam_poli)=".$yNow." AND MONTH(tgl_jam_poli)=".$mNow." AND DAY(tgl_jam_poli)=".$dNow." AND kode_dokter=".$kode_dokter);
// $no_antrian_regis=max_kode_number("tc_registrasi","nomor_antrian","WHERE YEAR(tgl_jam_masuk)=".$yNow." AND MONTH(tgl_jam_masuk)=".$mNow." AND DAY(tgl_jam_masuk)=".$dNow." AND kode_dokter=".$kode_dokter);
$no_antrian=$jadwal;
$no_antrian_regis=$jadwal;

$sqlCekPelayanan="SELECT
tc_registrasi.no_mr,
mt_bagian.nama_bagian,
tc_registrasi.flag_layanan,
tc_registrasi.nomor_antrian,
tc_registrasi.no_registrasi,
tc_kunjungan.no_kunjungan,
tc_kunjungan.status_keluar,
pl_tc_poli.tgl_jam_poli,
tc_registrasi.kode_dokter,
pl_tc_poli.id_pl_tc_poli,
pl_tc_poli.no_antrian,
mt_master_pasien.nama_pasien,
mt_master_pasien.jen_kelamin,
mt_master_pasien.almt_ttp_pasien,
mt_master_pasien.url_foto_pasien
FROM
mt_bagian
INNER JOIN pl_tc_poli ON mt_bagian.kode_bagian = pl_tc_poli.kode_bagian
INNER JOIN tc_kunjungan ON pl_tc_poli.no_kunjungan = tc_kunjungan.no_kunjungan
INNER JOIN tc_registrasi ON tc_kunjungan.no_registrasi = tc_registrasi.no_registrasi
INNER JOIN mt_master_pasien ON tc_registrasi.no_mr = mt_master_pasien.no_mr
WHERE YEAR(tgl_jam_poli)='$yNow' AND MONTH(tgl_jam_poli)='$mNow' AND DAY(tgl_jam_poli)='$dNow' AND tc_kunjungan.status_keluar is null AND tc_registrasi.no_mr = '$no_mr'";
$RunCekPelayanan=$db->Execute($sqlCekPelayanan);
$flag_pelayanan=$RunCekPelayanan->Fields("flag_pelayanan");
$tgl_jam_poli=$RunCekPelayanan->Fields("tgl_jam_poli");

$liatJadwal = "SELECT COUNT(tgl_jam_masuk) as jml FROM tc_registrasi where kode_dokter = $kode_dokter AND Day(tgl_jam_masuk)= $dNow AND MONTH(tgl_jam_masuk) = $mNow AND YEAR(tgl_jam_masuk) = $yNow AND tgl_jam_masuk = '$jam_awal'";
$hasilLiatJadwal = $db->Execute($liatJadwal);
while ($showjadwalada=$hasilLiatJadwal->fetchRow()){
	$ambiljadwalygada = $showjadwalada["jml"];
}

if($ambiljadwalygada<=0){
	if($flag_pelayanan!=""){
		$insertRegis["no_registrasi"]= $no_registrasi;
		$insertRegis["no_mr"]= $no_mr;
		$insertRegis["kode_kelompok"]= $nasabah;
		$insertRegis["kode_perusahaan"]= $kode_perusahaan;
		$insertRegis["kode_dokter"]= $kode_dokter;
		$insertRegis["kode_bagian_masuk"]= $kode_bagian;
		$insertRegis["stat_pasien"]= "Lama";
		$insertRegis["umur_tahun"]= $umur_pasien;
		$insertRegis["tgl_jam_masuk"]= $jam_awal;
		$insertRegis["no_askes"]= $no_polis;
		$insertRegis["flag_layanan"] = $fungsi_dokter;
		$insertRegis["nomor_antrian"]= $no_antrian_regis;
		$insertRegis["IdDaftarKlinik"]= $IdDaftarKlinik;

		$result =insert_tabel("tc_registrasi", $insertRegis);

		$insertKunjungan["no_kunjungan"]= $no_kunjungan;
		$insertKunjungan["no_registrasi"]= $no_registrasi;
		$insertKunjungan["no_mr"]= $no_mr;
		$insertKunjungan["kode_dokter"]= $kode_dokter;
		$insertKunjungan["kode_bagian_tujuan"]= $kode_bagian;
		$insertKunjungan["kode_bagian_asal"]= $kode_bagian;
		$insertKunjungan["tgl_masuk"]= $jam_awal;
		$insertKunjungan["umur_tahun"]= $umur_pasien;

		if($result) $result =insert_tabel("tc_kunjungan", $insertKunjungan);

		$insertPoli["kode_poli"]= $kode_poli;
		$insertPoli["no_kunjungan"]= $no_kunjungan;
		$insertPoli["kode_bagian"]= $kode_bagian;
		$insertPoli["tgl_jam_poli"]= $jam_awal;
		$insertPoli["kode_dokter"]= $kode_dokter;
		$insertPoli["nama_pasien"]= $nama_pasien;
		$insertPoli["flag_layanan"]= $fungsi_dokter;
		$insertPoli["no_antrian"]= $no_antrian;

		if($result) $result=insert_tabel("pl_tc_poli", $insertPoli);

		unset($updatePasien);
		$updatePasien["kode_kelompok"]= $nasabah;
		
		if($nasabah == AV_KODE_NASABAH_PERUSAHAAN){
			$updatePasien["kode_perusahaan"]= $yankes;
			$updatePasien["no_askes"]= $no_polis;
		}
		
		if($nasabah == AV_KODE_NASABAH_BPJS){
			$updatePasien["no_bpjs"]= $no_bpjs;
		}

		if($result) $result = update_tabel("mt_master_pasien", $updatePasien, "WHERE no_mr='$no_mr'");

	}else{
		if($tgl_jam_poli==$jam_awal){
			$data['code']=0;
		}else{
			$insertRegis["no_registrasi"]= $no_registrasi;
			$insertRegis["no_mr"]= $no_mr;
			$insertRegis["kode_kelompok"]= $nasabah;
			$insertRegis["kode_perusahaan"]= $kode_perusahaan;
			$insertRegis["kode_dokter"]= $kode_dokter;
			$insertRegis["kode_bagian_masuk"]= $kode_bagian;
			$insertRegis["stat_pasien"]= "Lama";
			$insertRegis["umur_tahun"]= $umur_pasien;
			$insertRegis["tgl_jam_masuk"]= $jam_awal;
			$insertRegis["no_askes"]= $no_polis;
			$insertRegis["flag_layanan"] = $fungsi_dokter;
			$insertRegis["nomor_antrian"]= $no_antrian_regis;
			$insertRegis["IdDaftarKlinik"]= $IdDaftarKlinik;

			$result =insert_tabel("tc_registrasi", $insertRegis);

			$insertKunjungan["no_kunjungan"]= $no_kunjungan;
			$insertKunjungan["no_registrasi"]= $no_registrasi;
			$insertKunjungan["no_mr"]= $no_mr;
			$insertKunjungan["kode_dokter"]= $kode_dokter;
			$insertKunjungan["kode_bagian_tujuan"]= $kode_bagian;
			$insertKunjungan["kode_bagian_asal"]= $kode_bagian;
			$insertKunjungan["tgl_masuk"]= $jam_awal;
			$insertKunjungan["umur_tahun"]= $umur_pasien;

			if($result) $result =insert_tabel("tc_kunjungan", $insertKunjungan);

			$insertPoli["kode_poli"]= $kode_poli;
			$insertPoli["no_kunjungan"]= $no_kunjungan;
			$insertPoli["kode_bagian"]= $kode_bagian;
			$insertPoli["tgl_jam_poli"]= $jam_awal;
			$insertPoli["kode_dokter"]= $kode_dokter;
			$insertPoli["nama_pasien"]= $nama_pasien;
			$insertPoli["flag_layanan"]= $fungsi_dokter;
			$insertPoli["no_antrian"]= $no_antrian;

			if($result) $result=insert_tabel("pl_tc_poli", $insertPoli);

			unset($updatePasien);
			$updatePasien["kode_kelompok"]= $nasabah;
			
			if($nasabah == AV_KODE_NASABAH_PERUSAHAAN){
				$updatePasien["kode_perusahaan"]= $yankes;
				$updatePasien["no_askes"]= $no_polis;
			}
			
			if($nasabah == AV_KODE_NASABAH_BPJS){
				$updatePasien["no_bpjs"]= $no_bpjs;
			}

			if($result) $result = update_tabel("mt_master_pasien", $updatePasien, "WHERE no_mr='$no_mr'");

		}
	}
}

// if(strtotime($jam_mulai)>=strtotime($jam_akhir){
// 	$data['code']=0;
// }
if($IdDaftarKlinik > 0){
	
	$DataJson['no_antrian']=$no_antrian_regis;
	$DataJson['tgl_jam_poli']=$jam_awal;
	$DataJson['IdDaftarKlinik']=$IdDaftarKlinik;
	$DataJson['keterangan']=$keterangan;
	include "../_ws_medis/post_konfirmasi_pasien.php";
}
//$result=false;
$db->CommitTrans($result!== false);

if($result){
	if($ambiljadwalygada>0){
		$data['code']=1;
		$data['no_kunjungan']=$no_kunjungan;
		$data['kode_bagian']=$kode_bagian;
	}
	else{
		$data['code'] = 0;
		$data['no_kunjungan']=$no_kunjungan;
		$data['kode_bagian']=$kode_bagian;
	}
}else{
	$data['code']=2;
	$data['no_kunjungan']=$no_kunjungan;
	$data['kode_bagian']=$kode_bagian;
}
echo json_encode($data);

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