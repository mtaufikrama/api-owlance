<?php

include "cek-token.php";

$sql="select * from tbl_pasien where no_ktp='$no_ktp'";

$getPasienlama=$db->Execute($sql);
while($datapasien=$getPasienlama->fetchRow()){
 
    // $qry_foto="select * from mt_master_pasien_img where no_mr='$datapasien[no_mr]'";
    // $ft_px=$db->Execute($qry_foto);
    // $no++;
    
    $tgllahir_px = $datapasien['tgl_lhr'];
    $umur_px = umur($tgllahir_px);

    $dp['mr_pasien']    = $datapasien['no_mr'];
    $dp['ktp_pasien']   = $datapasien['no_ktp'];
    $dp['nama_pasien']  = $datapasien['nama_pasien'];
    $dp['umur']         = $umur_px;
    $dp['alergi']       = $datapasien['alergi'];
    $dp['alamat']       = $datapasien['almt_ttp_pasien'];
    $dp['gol_darah']    = $datapasien['golongan_darah'];
    $dp['tgl_lhr']      = $datapasien['tgl_lhr'];
    $dp['tmp_lhr']      = $datapasien['tempat_lahir'];
    $dp['gender']       = $datapasien['jen_kelamin'];
    $dp['no_hp']        = $datapasien['no_hp'];
    $dp['email']        = $datapasien['email'];
    $dp['username']     = $datapasien['username'];
    $dp['foto_pasien']  = "null";
    $dp['foto_ktp']     = "null";

    $data['res'][]=$dp;
}
if(is_array($data['res'])) {
    $data['code']=200;
    echo json_encode($data);
}else {
    $data['code']=500;
    $data['msg']="Tidak ada data ditemukan";
    echo json_encode($data);
}

?>