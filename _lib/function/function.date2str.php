<?
function date2str($a = "",$mode="0"){
	global $db;
	/* $b=$db->UserDate($a,"Y-m-d H:i:s");
	list ($fulltgl, $wkt) = preg_split ('[ ]',$b);
	list ($tahun, $bulan, $tanggal) = preg_split ('[/.-]', $fulltgl); */
	$tanggal=date("d",strtotime2($a));
	$bulan	=date("m",strtotime2($a));
	$tahun	=date("Y",strtotime2($a));

	if($mode=="0"):
		//$hasil=$tanggal."-".$bulan."-".$tahun;
		$hasil=date("d-m-Y",strtotime2($a));
	else:
		//$hasil=$tanggal."/".$bulan."/".$tahun;
		$hasil=date("d/m/Y",strtotime2($a));
	endif;

	return $hasil;
}
?>
