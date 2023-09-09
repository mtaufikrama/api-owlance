<?php

include "cek-token.php";
loadlib("function","function.datetime");
// loadlib("class","Paging");
// $db->debug = true;

$input = json_decode(file_get_contents("php://input"),true);
$no_mr_px              = $input['no_mr'];
$no_registrasi_px      = $input['no_registrasi'];
$no_kunjungan_px       = $input['no_kunjungan'];

// ========================= PROFILE PASIEN =========================
$qry_px = $db->Execute("SELECT * FROM mt_master_pasien WHERE no_mr='$no_mr_px'");
while($get_px=$qry_px->fetchRow()){
	foreach($get_px as $key=>$val){
		$$key=$val;
	}
}
if($no_mr > 0){
	$tgl_lahir = $tgl_lhr;
	$umur_px = UmurV2($tgl_lahir);

	$arr_px['nama_px']      = $nama_pasien;
	$arr_px['nomr_px']      = $no_mr;
	$arr_px['umur_px']      = $umur_px;
	$arr_px['gender_px']    = $jen_kelamin;
	$arr_px['goldarah_px']  = $gol_darah;
	$arr_px['alergi_px']    = $alergi;
	$arr_px['no_ktp_px']    = $no_ktp;
	
	$dt_px[] = $arr_px;
}else{
	$dt_px = 500;
}
// $data['data_px'] = $dt_px;


// =========================== VITAL SIGN ========================== //
$sqlVS = &$db->Execute("SELECT * FROM gd_th_rujuk_ri where no_mr='$no_mr_px'");
while($get_vs=$sqlVS->fetchRow()){
	foreach($get_vs as $key=>$val){
		$$key=$val;
	}
}
if($no_registrasi > 0){
	$arrVS['keadaan_umum']		        = $keadaan_umum;
	$arrVS['kesadaran_pasien']	        = $kesadaran_pasien;
	$arrVS['tekanan_darah']		        = $tekanan_darah;
	$arrVS['nadi']				        = $nadi;
	$arrVS['suhu']			            = $suhu;
	$arrVS['pernafasan']		        = $pernafasan;
	$arrVS['berat_badan']		        = $berat_badan;
	$arrVS['tinggi_badan']		        = $tinggi_badan;
	$arrVS['lingkar_kepala']	        = $lingkar_kepala;
	$arrVS['lingkar_dada']		        = $lingkar_dada;
	$arrVS['lingkar_perut']		        = $lingkar_perut;
	$arrVS['heart_rate']		        = $heart_rate;
	$arrVS['respon_mata']		        = $respon_mata;
	$arrVS['respon_motorik']	        = $respon_motorik;
	$arrVS['respon_verbal']		        = $respon_verbal;
	$arrVS['spo2']				        = $spo2;
	$arrVS['lain_lain']			        = $lain_lain;
	$arrVS['skala_nyeri_face_number']	= $skala_nyeri_face_number;
	$dt_vs[] = $arrVS;
}else{
	$dt_vs = 500;
}

    // $dt_vs[] = $arrVS;
    // $data['data_vital_sign'] = $dt_vs;


// ================================ SOAP ================================ //
$sqlSOAP = &$db->Execute("SELECT * FROM tc_status_pasien WHERE no_mr='$no_mr' AND no_kunjungan='$no_kunjungan' AND no_registrasi='$no_registrasi_px'");
$sqlObj=&$db->Execute("SELECT id_tc_soap,keterangan FROM tc_soap WHERE no_mr='$no_mr' AND no_kunjungan='$no_kunjungan' AND no_registrasi='$no_registrasi_px'");
while($get_soap=$sqlSOAP->fetchRow()){
	foreach($get_soap as $key=>$val){
		$$key=$val;
	}
}
if($id_tc_status_pasien > 0){

	$arrSoap['id_tc_status_pasien']	 = $id_tc_status_pasien;
    $arrSoap['subjektif']       	 = $status_pasien;
    $arrSoap['assesment']       	 = $terapi;
    $arrSoap['id_tc_soap']        	 = $sqlObj->Fields('id_tc_soap');
    $arrSoap['objektif']        	 = $sqlObj->Fields('keterangan');
    $dt_soap[] = $arrSoap;
}else{
	$dt_soap = 500;
}
    // $data['data_soap'] = $dt_soap;

	if(!(is_array($dt_px)))
	{
		
		$data['code']=500;
		$data['msg'] = "Data tidak ditemukan untuk no antrian tersebut";
	}else{

		if(!(is_array($dt_vs))){

			$data['code']=201;
			$data['data_px'] = $arr_px;
			$data['msg'] = "Vital sign masih kosong";
		}else if(!(is_array($dt_soap))){

			$data['code']=301;
			$data['msg'] = "SOAP masih kosong";

			$data['data_px'] = $arr_px;
			$data['data_vital_sign'] = $arrVS;
			// $data['data_soap'] = $arrSoap;
		}else{

			$data['code']=200;
			$data['data_px'] = $arr_px;
			$data['data_vital_sign'] = $arrVS;
			$data['data_soap'] = $arrSoap;	
		}
	}
		
echo json_encode($data);
?>





