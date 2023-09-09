<?
	/**
	 * class SessionVars
	 *
	 * class untuk menyimpan data-data di dalam session secara sementara
	 *
	 */
	if (!class_exists("SessionVars")) {

		class SessionVars {
			private $sName;

			private function __construct($sName) {
				$this->sName = $sName;
			}

			/**
			 * function initVar
			 *
			 * fungsi ini berguna untuk inisialisasi variabel session
			 *
			 * $sessionObj =& SessionVars::initVar("dataPasien");			--> Membuat baru data session untuk dataPasien
			 * atau...
			 * $sessionObj =& SessionVars::initVar("dataPasien", false);	--> Menggunakan session yang telah ada untuk dataPasien
			 *
			 */
			public static function &initVar($sName = "", $bCreateNew = true) {
				$null = null;
				$obj = null;
				
				if ($sName == "") {
					// Parameter tidak lengkap
					echo "Nama variabel tidak lengkap !";
					return $null;
				}

				if ((isset($_SESSION[$sName])) && ($bCreateNew)) {
					// Bila session telah ada dan harus dibuat baru
					unset($_SESSION[$sName]);
					$result = session_register($sName);
					if ($result === false) return $null;
				} else if (($bCreateNew) || ((!$bCreateNew) && (!isset($_SESSION[$sName])))) {
					/* 
						Bila ingin buat baru 
						atau...
						Bila menggunakan session yang telah ada dan ternyata session belum tersedia
					*/
					$result = session_register($sName);
					if ($result === false) return $null;
				} 

				$obj = new SessionVars($sName);
				return $obj;
			}

			/**
			 * function setVar
			 * 
			 * fungsi untuk menyimpan data dalam variabel session
			 *
			 * $umurPasien = ....
			 * $result = $sessionObj->setVar("umumPasien", $umurPasien);
			 */
			public function setVar($vName, $vContent) {
				if (isset($_SESSION[$this->sName])) {
					$var = $_SESSION[$this->sName];
					$var[$vName] = $vContent;
					return true;
				} else
					return false;
			}

			/**
			 * function getVar
			 * 
			 * fungsi untuk mengambil data dalam variabel session
			 *
			 * $umurPasien = $sessionObj->getVar("umumPasien");
			 */
			public function getVar($vName) {
				if (isset($_SESSION[$this->sName])) {
					$var = $_SESSION[$this->sName];
					if (isset($var[$vName]))
						return $var[$vName];
					else
						return null;
				} else
					return null;
			}
		}
	}
?>