<?php
include "cek-token.php";
$idPerusahaan=base64_decode($id);
$SqlGetPer="select nama_perusahaan,alamat,email from dd_konfigurasi";
$RunGetPer=$db->Execute($SqlGetPer);

	while($TplGetPer=$RunGetPer->fetchRow()){

		$data['code']=200;
		$data['res'][]=$TplGetPer;
		echo json_encode($data);

	}

?>