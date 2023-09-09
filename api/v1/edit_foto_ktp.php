<!-- <?php 
include "cek-token.php";
$editFoto['foto_ktp'] = $fotoktp;
// $db->debug=true;
$sql="select no_mr, no_ktp from mt_master_pasien where no_ktp='$no_ktp'";
$cek_mr=$db->Execute($sql);
$nomr = $cek_mr->Fields('no_mr');

$qry="select * from mt_master_pasien_img where no_mr='$nomr'";
$cek_foto=$db->Execute($qry);
$px_foto = $cek_foto->fetchRow();
if ($px_foto > 0){
    $result = update_tabel("mt_master_pasien_img", $editFoto, "WHERE no_mr='$nomr'");

}else{
    $isi['no_mr']=$nomr;
    $isi['foto_ktp']=$fotoktp;
	$result = insert_tabel("mt_master_pasien_img",$isi);

}
if($result){
    $data['code'] = 200;
    $data['msg'] = "Foto KTP berhasil diedit";
}else{
    $data['code'] = 500;
    $data['msg'] = "Foto KTP gagal diedit";
}

echo json_encode($data);
?> -->