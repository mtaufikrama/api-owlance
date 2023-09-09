<?
require_once("../_lib/function/db.php");

function pilihan_tanggal($tanggal){
$a = 0;
	while ($a<31){
	$a++;
	$hasil ="<option value=\"<?=$a?>\" <?= $a==$tanggal ? \"selected\":\"\";?><?=$a?>";
	}
return $hasil;
}
?>