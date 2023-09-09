<?php
include 'cek-token.php';

$no=1;
$sql = &$db->Execute("SELECT * FROM mt_penyakit where ID1=$id");
while($dtp=$sql->fetchRow()){

    //Cek ICD10
    $IcdX = $dtp['IcdX'];
    $kel=baca_tabel("mt_master_icd10","kel"," where icd_10='".$IcdX."'");
	$icd_ten_kelompok=baca_tabel("mt_master_icd10","icd_10"," where icd_10='".$IcdX."'");
    if($kel <> "" ){
        $kelompok=baca_tabel("mt_icd10_kelompok","Nama_Kelompok"," where Kd_kelemopok like'%".$kel."%' ");
    }else{
        $kelompok="";
    }


	$arrSoap["no"]                  = $no++;  
	$arrSoap["ID"] 				    = $dtp['ID'];
    //SOA
	$arrSoap["Nama_Penyakit"] 			= $dtp['Nama_Penyakit'];
	$arrSoap["subyektif"] 				= $dtp['GKlinis'];
	$arrSoap["objektif"] 				= $dtp['Penyebab'];
	$arrSoap["analisis"] 				= $dtp['Pengobatan'];
    //View Data
	$arrSoap["catatan"] 		    = $dtp['Remark'];
	$arrSoap["Differential"] 		= $dtp['Differential'];
	$arrSoap["Prognosis"] 		    = $dtp['Prognosis'];
	$arrSoap["komplikasi"]	 	    = $dtp['pre_existing'];
	$arrSoap["penunjang"] 		    = $dtp['P_Lab'];
    //ICD10 View
	$arrSoap["IcdX"] 		        = $IcdX;
	$arrSoap["Diagnosa_Icdx"] 	    = $dtp['Diagnosa_Icdx'];
	$arrSoap["Class_Icdx"] 		   	= $dtp['Class'];
	$arrSoap["Lama_Rawat_Icdx"] 	= $dtp['Lama_Rawat'];
	$arrSoap["kelompok_Icdx"] 	    = $kelompok;
    $arrSoap["icd10_kelompok"]      = $icd_ten_kelompok;
}

if($arrSoap) {
    $data['code']=200;
	$data['data'] = $arrSoap;
}else {
    $data['code']=500;
    $data['msg']="Tidak ada data ditemukan";
}
echo json_encode($data);