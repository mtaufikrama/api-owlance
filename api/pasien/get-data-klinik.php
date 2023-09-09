<?php
include "cek-token.php";
// $db->debug=true;
// print_r($dataSend);

if($idKota==""){
	$SqlGetKlinik="select id_perusahaan,nama_perusahaan,alamat,email,logo_yankes,flag_bpjs from mt_perusahaan WHERE flag_mitra=1";
}else {
	$SqlGetKlinik="select id_perusahaan,nama_perusahaan,alamat,email,logo_yankes,flag_bpjs from mt_perusahaan WHERE id_dc_kota='$idKota' and flag_mitra=1";
}
$RunGetKlinik=$db->Execute($SqlGetKlinik);

while($TplGetKlinik=$RunGetKlinik->fetchRow()){
	$i++;
	if($flag_bpjs=='1'){
		$TplGetKlinik['ket']="BPJS";
	}else{
		$TplGetKlinik['ket']="Non BPJS";
	}
	$id_perusahaan=$TplGetKlinik['id_perusahaan'];
	$id_perusahaan=base64_encode($id_perusahaan);
	
	$logo_yankes=$TplGetKlinik['logo_yankes'];
	// if(empty($logo_yankes)){
	// 	$logo_yankes=$iss."/_images/logo.PNG";
	// }
	$TplGetKlinik['id']=$id_perusahaan;
	$TplGetKlinik['logo_yankes']=$logo_yankes;
	unset($TplGetKlinik['id_perusahaan']);
	$data['res'][]=$TplGetKlinik;
}
if(is_array($data['res'])){
	$data['code']=200;
	echo json_encode($data);
}else{
	$data['code']=500;
	$data['msg']="Tidak ada data ditemukan";
	echo json_encode($data);
}

?>