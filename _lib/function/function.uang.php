<?
function uang($jumlah,$decimal = false)
{
	if ($decimal)
		return number_format($jumlah,2,",",".");
	else
		return number_format($jumlah,0,",",".");
}
?>