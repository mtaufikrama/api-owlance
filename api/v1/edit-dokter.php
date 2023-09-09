<?php
include "cek-token.php";

$req = json_decode(file_get_contents("php://input"),TRUE);

$kode_dokter=$req['kode_dokter'];
$nama=$req['nama'];
$nik=$req['nik'];
$tgl_lhr=$req['tgl_lhr'];
$spesialis=$req['id_spesialis'];
$status=$req['id_status_dokter'];
$jenis_dokter=$req['id_jenis_dokter'];
$kode_bagian=$req['kode_bagian'];
$sip=$req['sip'];
$provinsi=$req['provinsi'];
$kota=$req['kota'];
$telp=$req['telp'];
$email=$req['email'];
$alamat=$req['alamat'];
$foto_ktp=$req['foto_ktp'];
$foto_dokter=$req['foto_dokter'];

if(isset($foto_dokter)){
		
	$ArrDat=explode(";",$foto_dokter);
	$ArrDat1=explode("/",$ArrDat[0]);
	$typeFile=$ArrDat1[1];

	$rawData = $foto_dokter;
	list($type, $rawData) = explode(';', $rawData);
	list(, $rawData)      = explode(',', $rawData);
	$alamatimg="../_images/foto/foto_dokter/";
	$nama_file_asli="_FotoDokter".$nama_pegawai.date("YmdHis").".".$typeFile;
	file_put_contents($alamatimg.$nama_file_asli, base64_decode($rawData));

	$file=$alamatimg.$nama_file_asli;
}

if(isset($foto_ktp)){
	
	$ArrDat=explode(";",$foto_ktp);
	$ArrDat1=explode("/",$ArrDat[0]);
	$typeFile=$ArrDat1[1];

	$rawData = $foto_ktp;
	list($type, $rawData) = explode(';', $rawData);
	list(, $rawData)      = explode(',', $rawData);
	$alamatimg="../_images/foto/foto_dokter/";
	$nama_file_asli="_KTPDokter".$nama_pegawai.date("YmdHis").".".$typeFile;
	file_put_contents($alamatimg.$nama_file_asli, base64_decode($rawData));

	$filektp=$alamatimg.$nama_file_asli;
}

//***********************************************************************************//

	
	unset($editMtKaryawan);
	$editMtKaryawan["nama_pegawai"]				= $nama;
	$editMtKaryawan["nik"]						= $nik;
	$editMtKaryawan["tgl_lahir"]				= $tgl_lhr;
	$editMtKaryawan["kode_spesialisasi"] 		= $spesialis;
	$editMtKaryawan["kode_bagian"] 				= $kode_bagian;
	$editMtKaryawan["kode_perusahaan_yankes"] 	= $kode_perusahaan;
	$editMtKaryawan["flag_tenaga_medis"] 		= $jenis_dokter;
	$editMtKaryawan["status_dr"] 				= $status;
	$editMtKaryawan["telp"] 					= $telp;
	$editMtKaryawan["email"] 					= $email;
	$editMtKaryawan["alamat"] 					= $alamat;
	if(isset($file)){
		$editMtKaryawan["url_foto_karyawan"] 	= $file;
	}
	if(isset($filektp)){
		$editMtKaryawan["url_ktp_karyawan"] 	= $filektp;	
	}

	$result = update_tabel("mt_karyawan", $editMtKaryawan, "WHERE  kode_dokter='$kode_dokter'");

//***********************************************************************************//
	unset($editDokterBagian);
	$editDokterBagian["kode_bagian"]		= $kode_bagian;
	$editDokterBagian["kd_bagian"]			= $kode_bagian;
	$editDokterBagian["fungsi_dokter"] 		= $jenis_dokter;
	
if($result) $result = update_tabel("mt_dokter_bagian", $editDokterBagian, "WHERE  kode_dokter='$kode_dokter'");

//	***********************************************************************************//
	unset($editDokterDetail);
	$editDokterDetail["no_izin_praktek"]	= $sip;
	$editDokterDetail["id_dc_propinsi"]		= $provinsi;
	$editDokterDetail["id_dc_kota"]			= $kota;
	$editDokterDetail["status_dokter"] 		= $status;
	$editDokterDetail["kode_bagian"] 		= $kode_bagian;
	
if($result) $result = update_tabel("mt_dokter_detail", $editDokterDetail, "WHERE  kode_dokter='$kode_dokter'");

$SqlGetDokter="SELECT * FROM mt_karyawan WHERE kode_dokter=$kode_dokter";

$RunGetDokter=$db->Execute($SqlGetDokter);
while($TplGetDokter=$RunGetDokter->fetchRow()){
	$data = $TplGetDokter;
}

if($result) {
	$datax['code']=200;
	$datax['msg']='Jadwal Dokter Ditemukan';
	$datax['jadwal']=$data;
} else {
	$datax['code']=500;
	$datax['msg']="Tidak Ada Jadwal Dokter";
}
echo json_encode($datax);
?>