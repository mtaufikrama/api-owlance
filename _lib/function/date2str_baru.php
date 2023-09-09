<?
function date2str_baru($a = "",$mode="0"){
	
	$thn=substr($a, 0, 4); 
	$bln=substr($a, 4, 2);
	$tgl=substr($a, 6, 2);

	if($mode=="0"):
		$hasil="$thn-$bln-$tgl";
	else:
		$hasil="$tgl-$bln-$thn";
	endif;

	if($a==""){$hasil="";}

	return $hasil;
}

function date2str_baru2($a = "",$mode="0"){
	global $db;
	$a = $db->UserDate($a, "Y-m-d H:i:s");
	
	$thn=substr($a, 0, 4); 
	$bln=substr($a, 5, 2);
	$tgl=substr($a, 8, 2);

	if($mode=="0"):
		$hasil=$thn.$bln.$tgl;
	else:
		$hasil=$tgl.$bln.$thn;
	endif;

	if($a==""){$hasil="";}

	return $hasil;
}
?>