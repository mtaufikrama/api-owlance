<?
/*
################################

Author	: Helmi Anwar
Versi	: 1.7.1 (Oracle)
Tanggal	: 10-9-09 15:29

################################
*/
if(!class_exists("logActivity")){
	
	
	class logActivity{
		var $_db;
		var $_usrtmp= array();

		public function __construct() {	
			global $db;
			global $usrtmp;
			$this->_db = $db;			
			$this->_usrtmp =$usrtmp;			
			//$db->debug=true;											
					}

		function insertLogActivity($aktivitas,$keterangan){
			
			global $PHP_SELF;
			$tgl_saja=date("Y-m-d");
			$tgl_lengkap=date("Y-m-d H:i:s");	
			
			$isi_LOG_USER_ACTIVITY["ID_DD_USER"]=$this->_usrtmp["id_dd_user"];
			$isi_LOG_USER_ACTIVITY["TGL_ACTIVITY"]=$tgl_lengkap;
			$isi_LOG_USER_ACTIVITY["IP_USER_ACTIVITY"]=USER_IP_ADDRESS;
			$isi_LOG_USER_ACTIVITY["AKTIVITAS"]=$aktivitas;
			$isi_LOG_USER_ACTIVITY["KETERANGAN_AKTIVITAS"]=$keterangan;
			$isi_LOG_USER_ACTIVITY["NAMA_FILE"]=$PHP_SELF;
			$isi_LOG_USER_ACTIVITY["SESSION_ID"]=$this->_usrtmp["session_id"];
			$hasil = insert_tabel("LOG_USER_ACTIVITY",$isi_LOG_USER_ACTIVITY);

			// tulis ke file log juga
			$isinya=$this->_usrtmp["id_dd_user"]."	";
			$isinya.=$tgl_lengkap."	";
			$isinya.=USER_IP_ADDRESS."	";
			$isinya.=$aktivitas."	";
			$isinya.=$keterangan."	";
			$isinya.=$PHP_SELF."	";
			$isinya.=$this->_usrtmp["session_id"]."\n";
			
			$this->tulisFile($isinya);


						
			return $hasil;
		}

		function loadLogActivity($id_dd_user_f=""){
			if($id_dd_user_f!=""){
				$hasil = read_tabel("LOG_USER_ACTIVITY_V","*","WHERE ID_DD_USER=$id_dd_user_f");
			}
			return $hasil;
		}
		
		
		function tulisFile($isi){
		$alamat=WWWROOT."/_log/userActivity/userActivity_".date("Ymd").".txt";
		$handle=fopen($alamat,"a+");
		fwrite($handle,$isi);
		fclose($handle);	
		}
		

	}
}

?>