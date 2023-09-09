<?php
include "cek-token.php";

$no_ktp=baca_tabel("mt_master_pasien","no_ktp","where no_ktp='$no_ktp'");
if(mb_strlen($no_ktp)==16){
	$data['code']=200;
	$data['msg']="Pasien Terdaftar di Klinik";
}else{
	$data['code']=500;
	$data['msg']="Pasien Tidak Terdaftar di Klinik, Harap Membawa KTP Saat datang ke Klinik Guna Melakukan Verifikasi";
}

echo json_encode($data);
?>