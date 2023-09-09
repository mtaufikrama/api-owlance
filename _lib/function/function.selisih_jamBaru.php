<?
if (!function_exists("selisih_jamBaru")) { 
 function selisih_jamBaru($ts1, $ts2) {
	$ts1 = strtotime2($ts1);
	$ts2 = strtotime2($ts2);
	$diff = abs($ts1-$ts2);

	$jam_float = $diff / (60 * 60);

	return $jam_float;
 }
}
?>