<?php

include "cek-token.php";
// $db->debug=true;
// print_r($dataSend);
// $email		=$Mail;
// $username	=$User;
// $pass		=base64_decode($Pass);
$id=0;

$username	=$User;
$pass 		=md5($Pass);

if(is_numeric($username)) {
    $SqlGetAksesPx="SELECT nama_pasien,no_ktp,url_foto_pasien from tbl_pasien where no_hp = '$username' AND `password` = '$pass';";
} else {
    $SqlGetAksesPx="SELECT nama_pasien,no_ktp,url_foto_pasien from tbl_pasien where email = '$username' AND `password` = '$pass';";
}

$RunGetAksesPx=$db->Execute($SqlGetAksesPx);
while($TplGetAksesPx=$RunGetAksesPx->fetchRow()) {
    // $no_ktp=$TplGetAksesPx['no_ktp'];
    // $qry_foto="SELECT * FROM mt_master_pasien WHERE no_ktp = '$no_ktp'";
    // $getFotopasien=$db->Execute($qry_foto);
    // $ft = $getFotopasien->Fields('foto_selfie');
    // if($ft == ""){
    // 	$foto = "null";
    // }else{
    // 	$foto = $ft;
    // }

    $foto = $TplGetAksesPx['url_foto_pasien'];
    if($foto != null) {
        $url_rs = "https://rspluit.sirs.co.id/";
        $foto = $url_rs.$foto;
    }

    $dl['nama_pasien']=$TplGetAksesPx['nama_pasien'];
    $dl['no_ktp']=$TplGetAksesPx['no_ktp'];
    $dl['foto_pasien']=$foto;
    $arrData=$dl;
}
if(is_array($arrData)) {
    //$kunci=getEncData($arrData);
    $dataRes['code']=200;
    $dataRes['res']=$arrData;
} else {
    $dataRes['code']=300;
    $dataRes['msg']='Maaf tidak ditemukan data pasien dengan data login anda';
}
echo json_encode($dataRes);
?>