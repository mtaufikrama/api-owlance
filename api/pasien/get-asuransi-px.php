<?php
include "cek-token.php";
// $db->debug=true;
// print_r($dataSend);

$GetAsuransi=$db->Execute("SELECT * FROM mt_perusahaan ORDER BY nama_perusahaan ASC");
$Asrn = $GetAsuransi->Fields('kode_perusahaan');
if($Asrn!=""){
	while($da=$GetAsuransi->fetchRow()){
		
        $dt_arn['kode_perusahaan']=$da['kode_perusahaan'];
		$dt_arn['nama_perusahaan']=$da['nama_perusahaan'];
	
        $data['code']=200;
        $data['list'][]=$dt_arn;
    }
}else{
	$data['code']=500;
	$data['msg']="data tidak ditemukan";
}

echo json_encode($data);
?>