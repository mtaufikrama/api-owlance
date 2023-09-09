<?
// ----------------------- FUNCTION applicationIni -----------------------

if (!function_exists("applicationIni")) {
	function applicationIni($txt="",$mode="1") {
		$hasil="D:/webapp/DEV/sisminbakum/DATA/application_oracle/";
		
		return $hasil;
	} // end of applicationIni($txt="",$mode="1")
} // end of if(!function_exists("applicationIni"))

// ----------------------- FUNCTION arsipSpecimen -----------------------

if (!function_exists("arsipSpecimen")) {
	function arsipSpecimen($mode="1") {
		switch ($mode) {
			case 1: //Buat proses file (upload,delete,edit)
				$hasil="D:/webapp/DEV/kliring/resigudang/DATA/images/specimen/";	
					break;
			case 2: //Tampil di img src
				$hasil="HTTP://".$_SERVER['SERVER_NAME']."/images/specimen/";
					break;	
				}
		return $hasil;
	} // end of arsipSpecimen($txt="",$mode="1")
} // end of if(!function_exists("arsipSpecimen"))

// ----------------------- FUNCTION arsipFoto -----------------------

if (!function_exists("arsipFoto")) {
	function arsipFoto($txt="1",$mode="1") {
		if ($txt=="1"){ //Buat proses file (upload,delete,edit)
			$hasil="D:/webapp/DEV/rsmelia/sirs/_images/Foto/";
				switch ($mode) {
					case 2: //pasien
						$hasil2="pasien/";
							break;
					case 5: //kosong
						$hasil2="kosong/";
							break;
					default: //
						$hasil2="";
					}
			$hasil_akhir = $hasil.$hasil2;
		} elseif ($txt=="2") {		//Tampil di img src Kodo pake alias webserver
			$hasil="HTTP://".$_SERVER['SERVER_NAME']."/_images/Foto/";
				switch ($mode) {
					case 2: //notaris
						$hasil2="pasien/";
							break;
					case 5: //kosong
						$hasil2="kosong/";
							break;
					
				}
					$hasil_akhir = $hasil.$hasil2;
		} else {		//panggil file dalam root
			$hasil="../images/Foto/";
				switch ($mode) {
					case 2: //notaris
						$hasil2="pasien/";
							break;
					case 5: //kosong
						$hasil2="kosong/";
							break;
					
				}
					$hasil_akhir = $hasil.$hasil2;
		}
		
		return $hasil_akhir;
	} // end of arsipFoto($txt="",$mode="1")
} // end of if(!function_exists("arsipFoto"))

// ----------------------- FUNCTION arsipLogo -----------------------

if (!function_exists("arsipLogo")) {
	function arsipLogo($txt="1",$mode="1") {
		if ($txt=="1"){ //Buat proses file (upload,delete,edit)
			$hasil="D:/webapp/DEV/kliring/resigudang/DATA/images/logo/";
				switch ($mode) {
					case 1: //LPK
						$hasil2="lpk/";
							break;
					case 2: //Pengawas
						$hasil2="pengawas/";
							break;
					case 3: //PG
						$hasil2="pg/";
							break;
					case 4: //
						$hasil2="";
							break;
					case 5: //Nasabah
						$hasil2="nasabah/";
							break;
					case 6: //Asuransi
						$hasil2="asuransi/";
							break;
					case 7: //Bank
						$hasil2="bank/";
							break;
					}
			$hasil_akhir = $hasil.$hasil2;
		} else {		//Tampil di img src
			$hasil="HTTP://".$_SERVER['SERVER_NAME']."/images/logo/";
				switch ($mode) {
					case 1: //LPK
						$hasil2="lpk/";
							break;
					case 2: //Pengawas
						$hasil2="pengawas/";
							break;
					case 3: //PG
						$hasil2="pg/";
							break;
					case 4: //
						$hasil2="";
							break;
					case 5: //Nasabah
						$hasil2="nasabah/";
							break;
					case 6: //Asuransi
						$hasil2="asuransi/";
							break;
					case 7: //Bank
						$hasil2="bank/";
							break;
					}
			$hasil_akhir = $hasil.$hasil2;
		}
		
		return $hasil_akhir;
	} // end of arsipLogo($txt="",$mode="1")
} // end of if(!function_exists("arsipLogo"))

// ----------------------- FUNCTION arsipGudang -----------------------

if (!function_exists("arsipGudang")) {
	function arsipGudang($mode="1") {
		switch ($mode) {
			case 1: //Buat proses file (upload,delete,edit)
				$hasil="D:/webapp/DEV/kliring/resigudang/DATA/images/gudang/";	
					break;
			case 2: //Tampil di img src
				$hasil="HTTP://".$_SERVER['SERVER_NAME']."/images/gudang/";
					break;	
				}
		return $hasil;
	} // end of arsipGudang($txt="",$mode="1")
} // end of if(!function_exists("arsipGudang"))

// ----------------------- FUNCTION arsipGudang -----------------------

if (!function_exists("arsipDokumen")) {
	function arsipDokumen($mode="1") {
		switch ($mode) {
			case 1: //Buat proses file (upload,delete,edit)
				$hasil="D:/webapp/DEV/sisminbakum/sabh_prototipe_oracle/_arsip/dokumen/";	
					break;
			case 2: //Tampil di img src
				$hasil="HTTP://".$_SERVER['SERVER_NAME']."_arsip/dokumen/";
					break;	
				}
		return $hasil;
	} // end of arsipGudang($txt="",$mode="1")
} // end of if(!function_exists("arsipGudang"))

?>