<?php

include "cek-token.php";

//no_registrasi

$no_mr = baca_tabel('tc_registrasi','no_mr',"where no_registrasi=$no_registrasi");

// $sqlpx = "SELECT a.nama_pasien, a.jen_kelamin, 
// a.tempat_lahir, a.tgl_lhr, a.gol_darah, 
// a.almt_ttp_pasien, a.alergi, b.nama_kelompok,
// c.nama_perusahaan, b.kode_kelompok, a.kode_perusahaan,a.tlp_almt_ttp,a.no_hp,a.tlp_kode_area
// FROM mt_master_pasien a
// LEFT JOIN mt_nasabah b
// ON a.kode_kelompok = b.kode_kelompok
// LEFT JOIN mt_perusahaan c
// ON a.kode_perusahaan = c.kode_perusahaan
// WHERE no_mr = '$no_mr'";

$sqlpx = "SELECT nama_pasien, jen_kelamin, 
tempat_lahir, tgl_lhr, gol_darah, 
almt_ttp_pasien, no_hp
FROM mt_master_pasien
WHERE no_mr = '$no_mr'";

$runpx=$db->Execute($sqlpx);

while($getpx=$runpx->fetchRow()) {
	$getpx['tgl_lhr'] = $getpx['tempat_lahir'] . ", " . $getpx['tgl_lhr'];
	unset($getpx['tempat_lahir']);
	$jenis_kelamin = $getpx['jen_kelamin'];
	include "../antol/cek-jenis-kelamin.php";
	$getpx['jenis_kelamin'] = $kelamin;
	unset($getpx['jen_kelamin']);
	$getpx['no_mr'] = $no_mr;
    $pasien=$getpx;
}

$sql="SELECT a.kode_bagian, b.nama_bagian, a.status_selesai, 
SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_rs) AS bill_rs, 
SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_dr1) AS bill_dr1, 
SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_dr2) AS bill_dr2, 
SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_dr3) AS bill_dr3, 
SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_rs_askes) AS bill_rs_askes, 
SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_dr1_askes) AS bill_dr1_askes, 
SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.bill_dr2_askes) AS bill_dr2_askes, 
SUM((CASE WHEN a.status_kredit = 1 THEN (-1) ELSE 1 END) * a.lain_lain) AS lain_lain 
FROM ks_antrian_loket_v a LEFT JOIN mt_bagian b ON a.kode_bagian = b.kode_bagian 
WHERE a.no_registrasi=$no_registrasi and (a.bill_rs > 0 OR  a.bill_dr1 > 0) GROUP BY a.kode_bagian, b.nama_bagian";

$run=$db->Execute($sql);

while($get=$run->fetchRow()) {
    $tunai[]=$get;
}

if(is_array($tunai)) {
    $data['code']=200;
    $data['pasien']=$pasien;
    $data['harga']=$tunai;
} else {
    $data['code']=500;
    $data['msg']="Tidak ada data ditemukan";
}
echo json_encode($data);
?>
