<?php

include "cek-token.php";
// include "../../_lib/function/db_login.php";
// include "../../../_lib/function/function.olah_tabel.php";
// $db->debug = true;

$editPasien['nama_pasien']      = $namaPasien;
$editPasien['no_hp']            = $no_hp;
$editPasien['umur_pasien']      = $umurPasien;
$editPasien['golongan_darah']   = $goldarah;
$editPasien['tgl_lhr']          = $tanggal_lhr;
$editPasien['tempat_lahir']     = $tempat_lhr;
$editPasien['jen_kelamin']      = $gender;
$editPasien['alergi']           = $alergi;
$editPasien['almt_ttp_pasien']  = $alamat;

//CEK DATA SUDAH TERDAFTAR ATAU BELUM
// $qr_no_hp = "select no_mr,no_hp from mt_master_pasien where no_hp='$no_HP'";
// $cekhp = $db->Execute($qr_no_hp);
// $nohp = $cekhp->Fields('no_hp');
// if($nohp != ""){
//     $data['code']=500;
//     $data['msg']="No. Telephone sudah digunakan";
// }else{
    $result = update_tabel("tbl_pasien", $editPasien, "WHERE no_ktp='$no_ktp'");
    // $db->CommitTrans($result!== false);
// }
if($result){
    $data['code']=200;
    $data['msg']="Profile berhasil di edit";
}else{
    $data['code']=500;
    $data['msg']="Profile gagal di edit";
}

echo json_encode($data);
?>

