<?php

include "cek-token.php";
include "../../_lib/function/function.olah_tabel_hr.php";

//kode_dokter, url

$sql = "SELECT no_induk, nama_pegawai, nik, url_ktp_karyawan as foto_ktp, kode_dokter, kode_spesialisasi, status_dr, flag_tenaga_medis as jenis_dokter, url_foto_karyawan as foto, kode_bagian, telp, alamat, email, flag_dokter from mt_karyawan where kode_dokter=$kode_dokter";

$run = $db->Execute($sql);

while ($tampil=$run->FetchRow()) {
    $no_induk = $tampil['no_induk'];
	$foto = $tampil['foto'];
	$foto_ktp = $tampil['foto_ktp'];
	if ($foto) {
		$tampil["foto"] = $url . $tampil["foto"];
	}
	if ($foto_ktp){
		$tampil["foto_ktp"] = $url . $tampil["foto_ktp"];
	}
    $status_dokter=baca_tabel("mt_dokter_detail", "status_dokter", "WHERE kode_dokter=$kode_dokter");
    if($status_dokter=='1') {
        $tampil["status_dokter"]= "Dokter Mitra";
    } else {
        $tampil["status_dokter"]= "Dokter Hisehat";
    }
    $status_dr = $tampil['status_dr'];
    switch ($status_dr) {
        case "0":
            $nm_status_dr = "Junior";
            break;
        case "1":
            $nm_status_dr = "Senior";
            break;
        case "2":
            $nm_status_dr = "Prof";
            break;
        case "3":
            $nm_status_dr = "Spesialis";
            break;
        case "4":
            $nm_status_dr = "Sub Spesialis";
            break;
        case "5":
            $nm_status_dr = "Umum";
            break;
        case "6":
            $nm_status_dr = "Terapis";
            break;
    }
	$tampil['nm_status_dr'] = $nm_status_dr;

    $flag_tenaga_medis = $tampil['jenis_dokter'];
    if($flag_tenaga_medis=='1') {
        $tenaga_medis="Full Time";
    } elseif($flag_tenaga_medis=='2') {
        $tenaga_medis="Part Time";
    } else {
        $tenaga_medis="Dokter Tamu";
    }
	$tampil['tenaga_medis'] = $tenaga_medis;
    
	$fungsi_dokter=baca_tabel("mt_dokter_bagian d, mt_bagian b","fungsi_dokter","WHERE d.kode_dokter=$kode_dokter AND d.kd_bagian=b.kode_bagian");
	if($fungsi_dokter=='1'){
		$fungsi_dokter= "Telekonsul";
	}elseif($fungsi_dokter=='2'){
		$fungsi_dokter= "Telemedicine";
	}else{
		$fungsi_dokter= "Homecare";
	}
	$tampil['fungsi_dokter']=$fungsi_dokter;
    $kode_bagian = $tampil['kode_bagian'];
    if ($kode_bagian){
        $tampil['nama_bagian'] = baca_tabel('mt_bagian', 'nama_bagian', "where kode_bagian=" .$kode_bagian);
    } else {
        $tampil['nama_bagian'] = null;
    }
    $kode_spesialisasi = $tampil['kode_spesialisasi'];
    if($kode_spesialisasi){
        $tampil['nama_spesialisasi']=baca_tabel("mt_spesialisasi_dokter", "nama_spesialisasi", " where kode_spesialisasi= " . $kode_spesialisasi);
    } else {
        $tampil['nama_spesialisasi'] = null;
    }
    $data[] = $tampil;
}

if(is_array($data)) {
    $datax['code']	=200;
    $datax['msg']	='Dokter Ditemukan';
    $datax['dokter']=$data;
} else {
    $datax['code']	=500;
    $datax['msg']	="Tidak Ada Dokter";
}
echo json_encode($datax);
?>