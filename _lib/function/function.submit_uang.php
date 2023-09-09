<?
// mode = "" berarti gak bisa minus dan bisa koma;
// mode = "1" berarti  bisa minus dan bisa koma;
function submit_uang($var=0) {
	$pola = "/\./i";
	$var = preg_replace($pola, "", $var);
	$var = str_replace(",",".",$var);

	return $var;
}
?>