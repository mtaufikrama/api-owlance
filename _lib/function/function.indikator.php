<?
function Count_BOR($jum_hari_rawat, $jum_hari, $jum_TT)
{
	if($jum_hari==0) 
		$Cal=0;
	else 
		$Cal=($jum_hari_rawat*100)/($jum_hari*$jum_TT);
	return $Cal;
}

function Count_ALOS($total_lama_rawat, $jum_pasien_keluar)
{
	if($jum_pasien_keluar==0)
		$Cal=0;
	else
		$Cal=$total_lama_rawat/$jum_pasien_keluar;
	return $Cal;
}

function Count_BTO($jum_pasien_keluar, $jum_TT)
{
	//echo "1=$jum_pasien_keluar,2=$jum_TT";
	$Cal=$jum_pasien_keluar/$jum_TT;
	return $Cal;
}

function Count_TOI($jum_TT, $jum_hari, $hari_rawat, $jum_pasien_keluar)
{
	if($jum_pasien_keluar==0)
		$Cal=0;
	else
		$Cal=(($jum_TT*$jum_hari)-$hari_rawat)/$jum_pasien_keluar;
	return $Cal;
}
?>