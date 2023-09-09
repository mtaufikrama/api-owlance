<?php
    session_start();
	require_once("../_lib/function/db_login.php");
	loadlib("function","function.olah_tabel");
	loadlib("function","function.datetime");
	loadlib("class","Paging");
	
	//---------------------------------------------
	$dataSend = json_decode(file_get_contents("php://input"),TRUE);
	foreach($dataSend as $key=>$val){
		$$key=$val;
	}
	//---------------------------------------------
	// $db->debug=true;
	 
    $sql 			= " SELECT blob_sip FROM tc_sip WHERE kode_dokter=$kode_dokter" ;
    $run_count		=$db->Execute($sql);

    $blob_sip =  $run_count->fields("blob_sip");
	//echo "lihat_file".$blob_sip;
	$filename = $blob_sip;
	$filarr=explode(";base64",$filename);
	$filarr1=explode("/",$filarr[0]);
	$filarr2=explode(":",$filarr1[0]);
	// print_r($filarr);
	$mimetype = $filarr2[1];
    if($mimetype=='image') {
		
		$file="<img alt='Pic' src='$blob_sip'>";
		
	}else if($mimetype=='application'){
		$file="<object data='$blob_sip' type='application/pdf' width='100%' height='500px'>";
		
	}else if($blob_sip!=""){
		$file="<img alt='Pic' src='$blob_sip'>";
	}
	$data['file']=$file;
	$data['mime']=$mimetype;
	echo json_encode($data);
	?>