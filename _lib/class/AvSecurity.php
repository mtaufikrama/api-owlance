<?
include "AvObjects.php";

if (!class_exists("AvSecurity")) {
	class AvSecurity extends AvObjects {

		private $_phpSessID;

		// --------------------- CONSTRUCTOR ---------------------

		public function __construct($db="",$phpSessID="") {
			parent::__construct();
			if ($db!="") {
				$this->setDB($db);
			}
			if ($phpSessID!="") {
				$this->_phpSessID=$phpSessID;
			}
		}

		// --------------------- PRIVATE METHODS ---------------------

		private function _cekUser($phpSessID="") {
		}

		// --------------------- PUBLIC METHODS ---------------------

		public function login($userName="",$userPass="") {
			$isValidUser=false;

			$qry = "SELECT * FROM dd_user WHERE username='".$userName."' AND password='".md5($userPass)."' AND status=0";
			$result_id = $this->_db->Execute($qry);

			$this->_prop["userInfo"] = $this->InternalFetch($result_id);

			while ($res=$result_id->FetchRow()) {
				$isValidUser=true;
				$id_dd_user=$res["id_dd_user"];
			}

			if ($isValidUser) {
				$sekarang=date("Y-m-d H:i:s");
				$sid=$this->_phpSessID;

				$this->logout();

				$sql_login="INSERT INTO log_user_login(id_dd_user,session_id,login_time,ip_address) VALUES (".$id_dd_user.",'".$sid."','".$sekarang."','".USER_IP_ADDRESS."')";
				$this->_db->Execute($sql_login);
			}

			unset($_SESSION["AV_SESSION"]);

			$session_data=array();
			$session_data["USER_IP_ADDRESS"]=USER_IP_ADDRESS;
			$_SESSION["AV_SESSION"]=$session_data;

			return $isValidUser;
		}

		public function isLoggedIn() {
			$isValid=false;
			$q="SELECT username FROM log_user_login a,dd_user b WHERE a.id_dd_user=b.id_dd_user AND logoff_time IS NULL AND session_id LIKE '".$this->_phpSessID."%' GROUP BY username";
			$r=$this->_db->Execute($q);

			if ($r->_numOfRows>0) {
				$isValid=true;
			}
			return $isValid;
		}

		public function logout() {
			if ($this->isLoggedIn()) {
				$sekarang=date("Y-m-d H:i:s");
				$sid=$this->_phpSessID;

				$sql_tutup_sblmnya="UPDATE log_user_login SET logoff_time='".$sekarang."' WHERE logoff_time IS NULL AND session_id='".$sid."'";
				$this->_db->Execute($sql_tutup_sblmnya);
			}
		}

		public function masukModul($modul) {
			$isValidUser=false;
			$sekarang=date("Y-m-d H:i:s");
			$sid=$this->_phpSessID;

			$sql_cari = "SELECT a.id_log_user,b.hak_akses FROM log_user_login a,dd_group_modul b WHERE b.id_dd_user=a.id_dd_user AND session_id LIKE '".$sid."%' AND b.id_dc_modul=".$modul." AND logoff_time IS NULL";
			$result_id = $this->_db->Execute($sql_cari);
			while ($res=$result_id->FetchRow()) {
				$id_log_user=$res["id_log_user"];
				$hak_akses_modul=$res["hak_akses"];
				$isValidUser=true;
			}

			if ($isValidUser) {
				$sql_login="INSERT INTO log_user_login_detail (id_log_user,login_time_detail,id_dc_modul,hak_akses) VALUES (".$id_log_user.", '".$sekarang."', ".$modul.", ".$hak_akses_modul.")";
				$this->_db->Execute($sql_login);
			}

			return $isValidUser;
		}

		public function hakModular() {
			//print_r($this);
			$modular=array();
			$t="admin_hak_user_v";
			$f="id_dc_modular";
			$o="WHERE id_dd_user=".$this->_prop["userInfo"]["id_dd_user"];
			$o.=" GROUP BY id_dc_modular,no_urut_modular";
			$o.=" ORDER BY no_urut_modular";
			$qModular="SELECT ".$f." FROM ".$t." ".$o;

			$rModular=$this->_db->Execute($qModular);
			while ($resModular=$rModular->FetchRow()) {
				$modular[]=$resModular["id_dc_modular"];
			}
			return $modular;
		}

		public function hakModul($modular="") {
			$modul=array();
			$t="admin_hak_user_v";
			$f="id_dc_modul";
			$o="WHERE id_dd_user=".$this->_prop["userInfo"]["id_dd_user"];
			if ($modular!="") $o.=" AND id_dc_modular=".$modular;
			$o.=" GROUP BY id_dc_modul,no_urut_modul";
			$o.=" ORDER BY no_urut_modul";
			$qModul="SELECT ".$f." FROM ".$t." ".$o;

			$rModul=$this->_db->Execute($qModul);
			while ($resModul=$rModul->FetchRow()) {
				$modul[]=$resModul["id_dc_modul"];
			}
			return $modul;
		}

		public function hakMenu($modul) {
		}

		public function hakSubMenu($modul,$menu) {
		}

		public function isModulAllowed($modul) {
			$allowedModul=$this->hakModul();
			return  in_array($modul,$allowedModul);
		}

		public function invalidPage($loginPage=AV_LOGIN_PAGE) {
			header('Location:'.$loginPage);
		}

		public function isSessionExpire() {
			return !isset($_SESSION["AV_SESSION"]);
		}

		public function saveRequestData() {
			$a=serialize($_GET);
			$b=serialize($_POST);
			$c=serialize($this->_db);
			ob_start();
			print_r($a);
			print_r($b);
			print_r($c);
			$d=ob_get_clean();
			//return $a;
			//return $b;
			//return $c;
			return $d;
		}

	} // end of class AvSession
}


?>