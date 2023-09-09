<?php

include "cek-token.php";
include "../../_lib/function/function.datetime.php";

//no_registrasi, keadaan_umum, kesadaran_pasien, tekanan_darah, nadi, suhu, pernafasan, tinggi_badan, berat_badan

$no_mr = baca_tabel('tc_kunjungan', 'no_mr', "where no_registrasi='$no_registrasi'");
$no_kunjungan = baca_tabel('tc_kunjungan', 'no_kunjungan', "where no_registrasi='$no_registrasi' and no_mr='$no_mr'");

$sql = "SELECT * FROM gd_th_rujuk_ri where no_mr='$no_mr' AND no_registrasi=$no_registrasi AND no_kunjungan=$no_kunjungan";

$sqlVS = $db->Execute($sql);
$kode_rujuk_ri		= $sqlVS->Fields('kode_rujuk_ri');

if($kode_rujuk_ri !=""){
    unset($editVitalSign);

    $editVitalSign["keadaan_umum"] 		= $keadaan_umum;
    $editVitalSign["no_registrasi"] 	= $no_registrasi;
    $editVitalSign["kesadaran_pasien"] 	= $kesadaran_pasien;
    $editVitalSign["tekanan_darah"] 	= $tekanan_darah;
    $editVitalSign["nadi"] 				= $nadi;
    $editVitalSign["suhu"] 				= $suhu;
    $editVitalSign["pernafasan"] 		= $pernafasan;
    $editVitalSign["berat_badan"]		= $berat_badan;	
    $editVitalSign["tinggi_badan"] 		= $tinggi_badan;
    $editVitalSign["heart_rate"] 		= $heart_rate;
    $editVitalSign["lingkar_perut"] 	= $lingkar_perut;
    $editVitalSign["no_kunjungan"] 		= $no_kunjungan;
    
    $result = update_tabel("gd_th_rujuk_ri", $editVitalSign, "WHERE  no_registrasi='$no_registrasi' AND no_kunjungan=$no_kunjungan");

}else{
    unset($insertVitalSign);

    $insertVitalSign["no_mr"] 				= $no_mr;
    $insertVitalSign["no_registrasi"] 		= $no_registrasi;
    $insertVitalSign["no_kunjungan"] 		= $no_kunjungan;
    $insertVitalSign["keadaan_umum"] 		= $keadaan_umum;
    $insertVitalSign["kesadaran_pasien"] 	= $kesadaran_pasien;
    $insertVitalSign["tekanan_darah"] 		= $tekanan_darah;
    $insertVitalSign["nadi"] 				= $nadi;
    $insertVitalSign["suhu"] 				= $suhu;
    $insertVitalSign["pernafasan"] 			= $pernafasan;
    $insertVitalSign["berat_badan"]			= $berat_badan;	
    $insertVitalSign["tinggi_badan"] 		= $tinggi_badan;
    $insertVitalSign["heart_rate"] 			= $heart_rate;
    $insertVitalSign["lingkar_perut"] 		= $lingkar_perut;
    $insertVitalSign["tgl_input"] 			= date('Y-m-d H:i:s');
    
    $result = insert_tabel("gd_th_rujuk_ri", $insertVitalSign);		
    
}

if($result){
    if($kode_rujuk_ri != ''){
        $data['code']=200;
        $data['msg']="Data Vital Sign berhasil diedit";
    } else {
        $data['code']=200;
        $data['msg']="Data Vital Sign berhasil ditambahkan";
    }

}else{
    $data['code']=500;
    $data['msg']="Maaf, Data Vital Sign Gagal ditambahkan";
}

echo json_encode($data);

?>
