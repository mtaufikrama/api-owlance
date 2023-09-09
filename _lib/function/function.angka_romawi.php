<?
function angka_romawi($angka)
{
// sementara sampe 12 dulu lagi males mikir, utamanya cuma buat banyaknya bulan doang hehe...

$satuan="I";
$limaan="V";
$puluhan="X";

if($angka==1):
	$hasil="I";
elseif($angka==2):
	$hasil="II";
elseif($angka==3):
	$hasil="III";
elseif($angka==4):
	$hasil="IV";
elseif($angka==5):
	$hasil="V";
elseif($angka==6):
	$hasil="VI";
elseif($angka==7):
	$hasil="VII";
elseif($angka==8):
	$hasil="VIII";
elseif($angka==9):
	$hasil="IX";
elseif($angka==10):
	$hasil="X";
elseif($angka==11):
	$hasil="XI";
elseif($angka==12):
	$hasil="XII";
endif;

return $hasil;
}
?>