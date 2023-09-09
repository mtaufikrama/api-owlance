<?php

include "cek-token.php";

$no_urut_periodik = max_kode_number("tc_surat_keterangan", "no_surat", " WHERE year(tgl_input)=".date('Y')." and month(tgl_input)=".date('m')." and id_dd_surat_keterangan=6");
$no_urut_periodik = str_pad($no_urut_periodik, 3, "0", STR_PAD_LEFT);
$bulan=angka_romawi(date('n'));
$surat_sakit = $no_urut_periodik."/Sket.01/DMS/".$bulan."/".date("Y");
$surat_sehat = $no_urut_periodik."/Sket.02/DMS/".$bulan."/".date("Y");

if($surat_sakit && $surat_sehat) {
    $datax['code']=200;
    $datax['nomor_surat_sakit']=$surat_sakit;
    $datax['nomor_surat_sehat']=$surat_sehat;
} else {
    $datax['code']=500;
    $datax['msg']="Tidak ada data ditemukan";
}
echo json_encode($datax);
