<?
function pembulatan($harga_jual_bruto)
{
	global $db;

	$cek_bulat=substr($harga_jual_bruto,-1,1);
	 if($cek_bulat >0){
		 if(strlen($harga_jual_bruto) > 1){
			$pecahan_satu=substr($harga_jual_bruto,-3,3);
			$pecahan_dua=substr($harga_jual_bruto,-3,2);
			$pecahan_tiga=substr($harga_jual_bruto,-3,1);
			$pembulatan_keatas=$pecahan_tiga +1;
			 $tambahin_nol=$pembulatan_keatas."00";
			 $selisih=$tambahin_nol-$pecahan_satu;
			 $hasil=$harga_jual_bruto + $selisih;
		 }else{
			 $hasil=100;
		 }

	 }else{
		 $hasil=$harga_jual_bruto;
	 }

	return $hasil;

}

?>