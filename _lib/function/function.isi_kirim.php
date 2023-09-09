<?
if(!defined("AV_LIB_LOADED")):
	define("WWWROOT",$DOCUMENT_ROOT);
	require_once(WWWROOT."/lib/db.php");
endif; #if(!defined("AV_LIB_LOADED")):

#===============================================================================
function isi_kirim($yg_tidak="")
{
	global $HTTP_POST_VARS,$HTTP_GET_VARS;

reset ($HTTP_POST_VARS);
$nama_var="";
$yg_gak_masuk=split(",",$yg_tidak);
$banyak_cekfield=count($yg_gak_masuk);

while (list ($key, $val) = each ($HTTP_POST_VARS)) 
	{
	$cek_ada=0;
	for($helmi1=0;$helmi1<$banyak_cekfield;$helmi1++)
		{
			if($yg_gak_masuk[$helmi1]==$key):    
				$cek_ada++;
				
			endif;
		} // end of for
		if($cek_ada<1)
		{   
			if(is_array($val)):
				while(list ($key2, $val2) = each ($val)):
					if(is_array($val2)):
						
						while(list ($key3, $val3) = each ($val2)):
							$nama_var=$nama_var."&".$key."[$key2][$key3]=".urlencode($val3);
						endwhile;

					else:
						$nama_var=$nama_var."&".$key."[$key2]=".urlencode($val2);
					endif;
				
				endwhile;
			else:
					$nama_var=$nama_var."&".$key."=".urlencode($val);
			endif;
		}// end of if
	} // end of while
reset ($HTTP_GET_VARS);
while (list ($kuncinya, $isinya) = each ($HTTP_GET_VARS)) 
	{
		$cek_ada=0;
		for($helmi1=0;$helmi1<$banyak_cekfield;$helmi1++)
		{
			if($yg_gak_masuk[$helmi1]==$kuncinya):
				$cek_ada++;
			    
			endif;
		} // end of for
		
		if($cek_ada<1)
		{	
			if(is_array($isinya)):
				while (list ($kuncinya2, $isinya2) = each ($isinya)) :
				
					if(is_array($isinya2)):
						while (list ($kuncinya3, $isinya3) = each ($isinya2)) :
							$nama_var=$nama_var."&".$kuncinya."[$kuncinya2][$kuncinya3]=".urlencode($isinya3);
						endwhile;
					else:
						$nama_var=$nama_var."&".$kuncinya."[$kuncinya2]=".urlencode($isinya2);
					endif;


				endwhile;

			else:
				$nama_var=$nama_var."&".$kuncinya."=".urlencode($isinya);			
			endif;
		}// end of if
	} // end of while
	
$nilai_lempar=substr($nama_var, 1);

return $nilai_lempar;
} # end of function isi_benar
?>