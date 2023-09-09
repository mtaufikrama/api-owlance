<?php
ini_set('max_execution_time', '0');
include "../../_lib/function/db_login.php";
include "../src/jwt.php";
include "../../_lib/function/function.olah_tabel.php";
// $db->debug=true;
$data = json_decode(file_get_contents("php://input"),TRUE);
// print_r($data);
$kata_asal	=$data['KodeApi'];

if (!function_exists("enkrip")) {
	function enkrip($txt="",$mode="1") {
		$hasil="";
		switch ($mode) {
			case 1: // averin encrypt simple				
				$txt=strrev($txt);
				$panjang_str=strlen($txt);
				for($h=0;$h<$panjang_str;$h++)
				{
					$hasil=$hasil.chr(((ord($txt[$h]))+3));
				}				
				break;
			case 2: // averin encrypt with key

			   $hasil=md5($txt);
			   break;
			
			case 3:
			   $hasil="";
			   break;
			}
	
		return $hasil;
	} // end of enkrip($txt="",$mode="1")
} // end of if(!function_exists("enkrip"))


// ----------------------- FUNCTION dekrip -----------------------

if (!function_exists("dekrip")) {
	function dekrip($txt="",$mode="1") {
		$hasil="";
		switch ($mode) {
			case 1: // averin decrypt simple
				
				$panjang_str=strlen($txt);
				
				for($h=0;$h<$panjang_str;$h++)
				{
					$hasil=$hasil.chr(((ord($txt[$h]))-3));
				}
				$hasil=strrev($hasil);
				
				break;
			case 2: // md5 encrypt

			   $hasil=md5($txt);
			   break;
			
			case 3:
			   $hasil="";
			   break;
			}
		return $hasil;
	} // end of function namabulan($bulan="")
}

$base=base64_encode($kata_asal);
$hasil=enkrip($base);

$KeyApi = $hasil;

$KeyCode = hash('sha256', $kata_asal.$hasil);

$cekToken = baca_tabel('ref_api_dmedis', 'IDApi', "where KeyCode = '$KeyCode'");

$jmlId = baca_tabel('ref_api_dmedis', 'count(IDApi)');
$IDApi = $jmlId + 1;

$data['IDApi'] = $IDApi;
$data['KodeApi'] = $kata_asal;
$data['KeyApi'] = $KeyApi;
$data['KeyCode'] = $KeyCode;

if ($cekToken){
	$Resdata['code']=500;
	$Resdata['msg']='Akses Ditolak';
} else {
	$result = insert_tabel('ref_api_dmedis', $data);
	if ($result) {
		$Resdata['code']=200;
		$Resdata['msg']='Akses berhasil ditambahkan';
	} else {
		$Resdata['code']=500;
		$Resdata['msg']='Maaf, Akses Gagal ditambahkan';
	}
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($Resdata);
?>