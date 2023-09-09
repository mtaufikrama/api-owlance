<?
// function ambil jam dr DB /////////////////////
if (!function_exists("ambil_jamDB")) {
	function ambil_jamDB($a = ""){
		global $db;
		$a = $db->UserDate($a, "Y-m-d H:i:s");
		
		$jam=substr($a, -5, 2); 
		$mnt=substr($a, -3, 2);
		$dtk=substr($a, -1, 2);

		$hasil = $jam.":".$mnt.":".$dtk;
		
		return $a=="" ? "" : $hasil;
	}
} // end of if (!function_exists("ambil_jam"))

// function ambil jam dr HTML /////////////////////
if (!function_exists("ambil_jam")) {
	function ambil_jam($a = "") {
		$jam=substr($a, -5, 2);  
		$mnt=substr($a, -3, 2);
		$dtk=substr($a, -1, 2);

		$hasil=$jam.":".$mnt.":".$dtk;
		
		return $a=="" ? "" : $hasil;
	}
} // end of if (!function_exists("date2str_baru"))
?>