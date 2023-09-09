<?php
// ----------------------- FUNCTION enkrip -----------------------

if (!function_exists("enkrip")) {
	function enkrip($txt="",$mode="1") {
		$hasil="";
		switch ($mode) {
			case 1: // averin encrypt simple				
				$txt=strrev($txt);
				$panjang_str=strlen($txt);
				for($h=0;$h<$panjang_str;$h++)
				{
					$hasil=$hasil.chr(((ord($txt[$h]))+3));
				}				
				break;
			case 2: // averin encrypt with key

			   $hasil=md5($txt);
			   break;
			
			case 3:
			   $hasil="";
			   break;
			}
	
		return $hasil;
	} // end of enkrip($txt="",$mode="1")
} // end of if(!function_exists("enkrip"))


// ----------------------- FUNCTION dekrip -----------------------

if (!function_exists("dekrip")) {
	function dekrip($txt="",$mode="1") {
		$hasil="";
		switch ($mode) {
			case 1: // averin decrypt simple
				
				$panjang_str=strlen($txt);
				
				for($h=0;$h<$panjang_str;$h++)
				{
					$hasil=$hasil.chr(((ord($txt[$h]))-3));
				}
				$hasil=strrev($hasil);
				
				break;
			case 2: // md5 encrypt

			   $hasil=md5($txt);
			   break;
			
			case 3:
			   $hasil="";
			   break;
			}
		return $hasil;
	} // end of function namabulan($bulan="")
} // end of if(!function_exists("namabulan"))

?>