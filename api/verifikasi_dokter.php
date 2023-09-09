<?php
	
session_start();
require_once("../_lib/function/db_login.php");
loadlib("function","function.olah_tabel");

$dataSend = json_decode(file_get_contents("php://input"),TRUE);
foreach($dataSend as $key=>$val){
	$$key=$val;
}
$db->BeginTrans();
//////////////////////////////////////////////////////////////////////
	$sqlXX = "SELECT k.email,k.nama_pegawai,k.no_induk,b.id_dd_user FROM mt_karyawan k left join mt_spesialisasi_dokter d on k.kode_spesialisasi=d.kode_spesialisasi left join mt_bagian a on k.kode_bagian=a.kode_bagian join dd_user b on k.no_induk=b.no_induk WHERE  tgl_verifikasi is null and k.kode_dokter>0  and k.kode_dokter=$kode_dokter";
	$sqlHasil=& $db->Execute($sqlXX);
	
	while($tampilHasil=$sqlHasil->FetchRow()){
		    //echo "TEST";
			$email			=$tampilHasil["email"];
			$no_induk		=$tampilHasil["no_induk"];
			$nama_pegawai	=$tampilHasil["nama_pegawai"];
			$id_dd_user		=$tampilHasil["id_dd_user"];
	}
	//////////////////////////////////////////////////////////////////////
	unset($fld);
	$fld["flag_verifikasi"]				=1;
	$fld["tgl_verifikasi_dokter"]		=date("Y-m-d H:i:s");
	$fld["id_dd_user_verifikasi"]		=$_SESSION['logininfo']['id_dd_user'];
	$result = update_tabel("mt_karyawan",$fld,"WHERE no_induk='$no_induk'");
	//echo "Email".$email;
	//echo "Pass".$nama_pegawai;
	//die();
	//////////////////////////////////////////////////////////////////////
	$db->CommitTrans($result !== false);
	if($result){
		$data['code']=200;
		$data['nama_pegawai']=$nama_pegawai;
	}else{
		$data['code']=500;
	}
	echo json_encode($data);
?>