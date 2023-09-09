<?php

include "cek-token.php";
include '../../_lib/function/function.olah_tabel_hr.php';

//no_registrasi, icd_10, icd_asterik, kasus_pasien

$no_kunjungan = baca_tabel('tc_kunjungan', 'no_kunjungan', "where no_registrasi=$no_registrasi");
$kode_dokter=baca_tabel('tc_registrasi', 'kode_dokter', "where no_registrasi=$no_registrasi");
$no_mr=baca_tabel('tc_registrasi', 'no_mr', "where no_registrasi=$no_registrasi");
$kode_bagian=baca_tabel('tc_registrasi', 'kode_bagian_masuk', "where no_registrasi=$no_registrasi");
$diagnosa=baca_tabel("th_riwayat_pasien", "diagnosa_akhir", "WHERE no_registrasi=".$no_registrasi);

if (substr($kode_bagian, 0, 2) == '03') {
    $tipeRL = 'B';
} else {
    $tipeRL = 'A';
}
//=============================================================//
$data_pasien= data_tabel("mt_master_pasien", "where no_mr='".$no_mr."'");

$tgl_periksa=date('Y-m-d H:i:s');
if($icd_10) {
    $diagnosa_icd=  baca_tabel("mt_master_icd10", "nama_icd", "where icd_10='".$icd_10."'");
} else {
    if($diagnosa) {
        $diagnosa_icd=$diagnosa;
    } else {
        $diagnosa_icd=null;
    }
}

if($kode_dokter) {
    $sql1=read_tabel("mt_karyawan", "*", "where kode_dokter='$kode_dokter'");
    while ($tampil=$sql1->FetchRow()) {
        $nama_pegawai		= $tampil["nama_pegawai"];
        $kode_spesialisasi	= $tampil["kode_spesialisasi"];
        $url_foto_karyawan	= $tampil["url_foto_karyawan"];

    }

    $nama_spesialisasi=baca_tabel("mt_spesialisasi_dokter", "nama_spesialisasi", " where kode_spesialisasi=$kode_spesialisasi");

} else {
    $nama_pegawai="";
    $nama_spesialisasi="-";

}

$sql = $db->Execute("SELECT * FROM mt_master_pasien where no_mr='$no_mr'");
$no_mr = $sql->fields["no_mr"];
$nama_pasien = $sql->fields["nama_pasien"];
$tgl_lhr = $sql->fields["tgl_lhr"];
$umur = $sql->fields["umur_pasien"];
$jen_kelamin = $sql->fields["jen_kelamin"];

// $result = true;
// $db->BeginTrans();

unset($insertThRiwayatPasien);
$insertThRiwayatPasien["no_registrasi"] = $no_registrasi;
    $insertThRiwayatPasien["no_kunjungan"] = $no_kunjungan;
    $insertThRiwayatPasien["no_mr"] = $no_mr;
    $insertThRiwayatPasien["nama_pasien"] = $nama_pasien;
    $insertThRiwayatPasien["dokter_pemeriksa"] = $nama_pegawai;//kode dokter
    $insertThRiwayatPasien["tgl_periksa"] = $tgl_periksa;//
    $insertThRiwayatPasien["kode_bagian"] = $kode_bagian;// poli
    $insertThRiwayatPasien["diagnosa_akhir"] = $diagnosa_icd;// dapat dari ICD 10 akhir
    $insertThRiwayatPasien["icd_10"] = $icd_10;//kelompok
    $insertThRiwayatPasien["icd_10_akhir"] = $icd_10;//icd akhir
    $insertThRiwayatPasien["kode_asterik"] = $icd_asterik;//kalo ada
    $insertThRiwayatPasien["diagnosa_jenis"] = 1;
    if($icd_10) {
        $result = insert_tabel("th_riwayat_pasien", $insertThRiwayatPasien);
    }
    $id_riwayat=baca_tabel('th_riwayat_pasien', 'kode_riwayat',"where no_kunjungan=$no_kunjungan");

//////////////////////////////////////////////////////////////////////


//  unset($insertThIcd10Pasien);
if ($result) {
    $insertThIcd10Pasien["kode_riwayat"] = $id_riwayat;
    $insertThIcd10Pasien["tgl_jam"] = $tgl_periksa;
    $insertThIcd10Pasien["kode_icd"] = $icd_10;
    $insertThIcd10Pasien["kode_asterik"] = $icd_asterik;
    $insertThIcd10Pasien["no_mr"] = $no_mr;
    $insertThIcd10Pasien["no_registrasi"] = $no_registrasi;
    $insertThIcd10Pasien["kode_bagian"] = $kode_bagian;
    $insertThIcd10Pasien["kode_dokter"] = $kode_dokter;
    $insertThIcd10Pasien["diagnosa"] = $diagnosa_icd;
    $insertThIcd10Pasien["tipe_rl"] = $tipeRL;
    $insertThIcd10Pasien["status_itung"] = 1;
    $insertThIcd10Pasien["umur"] = $umur;
    $insertThIcd10Pasien["gender"] = $jen_kelamin;
    $insertThIcd10Pasien["status_hidup"] = 1;
    $insertThIcd10Pasien["umur_rl"] = $umur;
    $insertThIcd10Pasien["kelompok_icd"] = $icd_10;
    $insertThIcd10Pasien["status_itung"] = $kasus_pasien;
    if($icd_10) {
        $result = insert_tabel("th_icd10_pasien", $insertThIcd10Pasien);
    }
}

if ($result){
    $datax['code']=200;
    $datax['msg']='Data Berhasil ditambahkan';
} else {
    $datax['code']=500;
    $datax['msg']='Maaf, Data Gagal ditambahkan';}
echo json_encode($datax);
