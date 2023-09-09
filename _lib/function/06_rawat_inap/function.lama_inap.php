<?
function ngitung_lama_inap($kkel,$ngecek,$ngehari,$kri,$trf,$ngeper="",$r=0){

	$xx = ($ngecek/24) - $ngehari ;

		if ($kkel == 1) {
				  
				if (($ngehari >= 2) and ($ngecek > 30) and ($xx >= 0.25)) {
				  $lama_inap = $ngehari + 1;
				  $a = "pp";
				} elseif (($ngehari >= 2) and ($ngecek > 30) and ($xx < 0.25))  {
				  $lama_inap = $ngehari;
				  $a = "zz";
				} elseif (($ngehari == 2) and ($ngecek < 30)) {
				  $lama_inap = 2;
				  $a = "vv";
				} elseif (($ngehari == 1) and ($ngecek > 30)) {
				  $lama_inap = 2;
				  $a = "gg";
				} elseif (($ngehari == 2) and ($ngecek == 30)) {
				  $lama_inap = 2;
				  $a = "oo";
				} elseif (($ngecek >= 3) and ($ngecek < 30)) {
				  $lama_inap = 1;
				  $a = "ll";		
				} elseif ($ngecek < 3) {
				  $lama_inap = $ngecek;
				  $batas = 1;
				}
				
				$hrg_a = $lama_inap * $trf;
				$temp_a = $temp_a + $hrg_a;
									  
		 } elseif ($kkel == 2) { 
		    $lama_inap = $ngehari;
		    if ($lama_inap == 0) {
			 $lama_inap = 1;
		    }

			$hrg_c = $lama_inap * $trf;
			$temp_c = $temp_c + $hrg_c;
		 
		 } else {
					  
			$pers = baca_tabel("perusahaan","askes","where kode_perusahaan = '$ngeper'");
			
			if ($pers == '1') {
			   $lama_inap = $ngehari;
			   if ($lama_inap == 0) {
				 $lama_inap = 1;
			   }
			   $a = "mm";
			} else {
			   
			   if ( $r > 1 ) {
			     $lama_inap = $ngehari ;	
			   } else {
			     $lama_inap = $ngehari + 1;	
			   }
			   $a = "rr";
			}

			$hrg_b = $lama_inap * $trf;
			$temp_b = $temp_b + $hrg_b;
											  
		} 

$totalan = $temp_a + $temp_b + $temp_c;

$hasil[1] = $lama_inap;
$hasil[2] = $totalan;
$hasil[3] = $batas;
$hasil[4] = $ngecek;
$hasil[5] = $ngehari;
$hasil[6] = $kkel;

return $hasil;
}
?>