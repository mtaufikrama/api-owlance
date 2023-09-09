<?
function cek_kiriman()
{
	global $HTTP_POST_VARS,$HTTP_GET_VARS;

	$HTTP_POST_VARS = isset($HTTP_POST_VARS) ? $HTTP_POST_VARS : $_POST;
	$HTTP_GET_VARS = isset($HTTP_GET_VARS) ? $HTTP_GET_VARS : $_GET;


reset ($HTTP_POST_VARS);
$nama_var="";
	while (list ($key, $val) = each ($HTTP_POST_VARS)) // --------------------------------------------------------------------
	{
		if(is_array($val))
		{
			while (list ($key2, $val2) = each($val)) // --------- jika satu array --------------
			{
				if(is_array($val2))
				{
						while (list ($key3, $val3) = each($val2)) // --------- jika dua array --------------
						{
							
							if(is_array($val3))
							{
									while (list ($key4, $val4) = each($val3)) // --------- jika tiga array --------------
									{
										echo $key."[".$key2."][".$key3."][".$key4."] = ".$val4."<br>";		// TAMPILIN							
									} // end of --------- jika tiga array --------------
							}
							else
							{
									echo $key."[".$key2."][".$key3."] = ".$val3."<br>"; // TAMPILIN
							}




						} // end of --------- jika dua array --------------
						
						
				}
				else
				{
					echo $key."[".$key2."] = ".$val2."<br>"; // TAMPILIN
				}

			} // end of --------- jika satu array --------------
			
		}
		else
		{
		echo $key." = ".$val." <br>"; // TAMPILIN
		}
	} // while (list ($key, $val) = each ($HTTP_POST_VARS)) ----------------------------------------------------------------
reset ($HTTP_GET_VARS);
while (list ($kuncinya, $isinya) = each ($HTTP_GET_VARS)) 
	{
	if(is_array($isinya))
		{
			while (list ($kuncinya2, $isinya2) = each($isinya)) // --------- jika satu array --------------
			{
				if(is_array($isinya2))
				{
						while (list ($kuncinya3, $isinya3) = each($isinya2)) // --------- jika dua array --------------
						{
							
							if(is_array($isinya3))
							{
									while (list ($kuncinya4, $isinya4) = each($isinya3)) // --------- jika tiga array --------------
									{
										echo $kuncinya."[".$kuncinya2."][".$kuncinya3."][".$kuncinya4."] = ".$isinya4."<br>";		// TAMPILIN							
									} // end of --------- jika tiga array --------------
							}
							else
							{
									echo $kuncinya."[".$kuncinya2."][".$kuncinya3."] = ".$isinya3."<br>"; // TAMPILIN
							}




						} // end of --------- jika dua array --------------
						
						
				}
				else
				{
					echo $kuncinya."[".$kuncinya2."] = ".$isinya2."<br>"; // TAMPILIN
				}

			} // end of --------- jika satu array --------------
			
		}
		else
		{
		echo $kuncinya." = ".$isinya." <br>"; // TAMPILIN
		}
	}
//$nilai_lempar=substr($nama_var, 1);

//return $nilai_lempar;
} # end of function isi_benar

?>