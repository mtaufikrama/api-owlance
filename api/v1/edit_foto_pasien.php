<!-- <?php 
include "cek-token.php";
$editFoto['url_foto_pasien'] = base64_decode($fotoProfile);
// $db->debug=true;
// $sql="select no_mr, no_ktp from mt_master_pasien where no_ktp='$no_ktp'";
// $cek_mr=$db->Execute($sql);
// $nomr = $cek_mr->Fields('no_mr');

// $qry="select no_ktp,url_foto_pasien from tbl_pasien where no_ktp='$no_ktp'";
// $cek_foto=$db->Execute($qry);
$px_foto = baca_tabel("tbl_pasien","url_foto_pasien","WHERE no_ktp='".$no_ktp."'");
if($px_foto!="" ){
    $result = update_tabel("tbl_pasien", $editFoto, "WHERE no_mr='$nomr'");
}else{
    $data["code"] = 200;
    $data["msg"] = "Data Pasien tidak ditemukan";
}

if($result){
    $data['code'] = 200;
    $data['msg'] = "Foto berhasil diedit";
}else{
    $data['code'] = 500;
    $data['msg'] = "Foto gagal diedit";
}

echo json_encode($data);
?> -->