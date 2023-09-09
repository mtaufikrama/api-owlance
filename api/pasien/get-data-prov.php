<?php
include "cek-token.php";
$SqlGetProp="select id_dc_propinsi,nama_propinsi from dc_propinsi where id_dc_propinsi in(select DISTINCT(id_dc_propinsi) as id_dc_propinsi from mt_perusahaan where id_dc_propinsi is not null and flag_mitra=1)";
$RunGetProp=$db->Execute($SqlGetProp);
while($TplGetProp=$RunGetProp->fetchRow()){
	$data['idProv']=$TplGetProp['id_dc_propinsi'];
	$data['nama']=$TplGetProp['nama_propinsi'];
	$json[]=$data;
}
echo json_encode($json);
?>