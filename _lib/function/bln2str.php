<?
function bln2str($nilainya="",$mode="1")
{
if($mode=="1"):
	$nama_bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
elseif($mode=="2"):
	$nama_bulan=array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agust","Sep","Okt","Nov","Des");
endif;

if ($nilainya=="")
	{
	$nilainya=date("n");
	}

$bulan=$nama_bulan[$nilainya-1];

return($bulan);
}

?>