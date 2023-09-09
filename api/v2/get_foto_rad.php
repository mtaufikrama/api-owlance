<?php
require_once("../_lib/function/db_login.php");
loadlib("function","variabel");
loadlib("function","function.olah_tabel");
loadlib("function","function.datetime");
loadlib("class","Paging");
// $db->debug=true;
$input = json_decode(file_get_contents('php://input'),TRUE);
foreach($input as $key=>$val){
	$$key=$val;
}

// Foto Radiologi
$url_rs = "https://c00001.sirs.co.id/";
$nof = 0;
$sql_gambar=read_tabel("tc_gmb_rad","*"," where id_rad=".$kd_penunjang." and kode_tarif=".$kode_tarif);
$lokasi='/_arsip/foto_rad/';
while($df=$sql_gambar->FetchRow()){

	
	$lokasifoto = $df["url_foto"];
    $ft_rad['no_urut'] 		= $nof++;
    $ft_rad['url_foto_rad'] = $url_rs.$lokasi.$lokasifoto;

    $data['fotorad'][]=$ft_rad;
}

if(is_array($data['fotorad'])){
	$data['code']=200;
	echo json_encode($data);
}else{
	$data['code']=500;
	echo json_encode($data);
}

?>