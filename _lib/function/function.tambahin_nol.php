<?
if (!function_exists("TambahinNol")) {
	function TambahinNol($nomornya,$max_panjang){
	$panjang_mr=strlen($nomornya);
	$sisa_panjang=$max_panjang-$panjang_mr;
	$tambah_nol="";

	for($i=1;$i<=$sisa_panjang;$i++)
		{
			$tambah_nol=$tambah_nol."0";
		}
	$hasilnya=$tambah_nol.$nomornya;

	return $hasilnya;
	} // end of function angka_romawi($angka)
} // end of if(!function_exists("angka_romawi"))


?>