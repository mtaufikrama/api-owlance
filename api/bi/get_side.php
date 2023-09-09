<?php
$SqlGetSite="select url_site from mt_perusahaan where url_site is not null";
$RunGetSite=$db->Execute($SqlGetSite);
while($TplGetSite=$RunGetSite->fetchRow()){
	$data[]=$TplGetSite;
}
echo json_encode($data);
?>