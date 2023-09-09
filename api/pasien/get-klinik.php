<?php
include "cek-token.php";
$SqlGetKlinik="select * from mt_perusahaan WHERE flag_mitra=1 ";
$RunGetKlinik=$db->Execute($SqlGetKlinik);
$i=0;
while($TplGetKlinik=$RunGetKlinik->fetchRow()){
	$id_perusahaan		=$TplGetKlinik['id_perusahaan'];
	$id_perusahaan		=base64_encode($id_perusahaan);
	$TplGetKlinik['id_perusahaan']=$id_perusahaan;
	if($id_dc_kota!=""){
		$nama_kota=baca_tabel("dc_kota","nama_kota"," where id_dc_kota=$id_dc_kota");
		$TplGetKlinik['nama_kota']=$nama_kota;
	}
	
	if(empty($logo_yankes)){
		$logo_yankes="_images/bpjsicons/05poliklinik.gif";
		$TplGetKlinik['logo_yankes']=$base_url.$logo_yankes;
	}
	if($flag_bpjs=='1'){
		$ket="BPJS";
		$TplGetKlinik['ket']=$ket;
	}else{
		$ket="Non BPJS";
		$TplGetKlinik['ket']=$ket;
	}
	
	$dataJson[]=$TplGetKlinik;
}

echo json_encode($dataJson);
?>