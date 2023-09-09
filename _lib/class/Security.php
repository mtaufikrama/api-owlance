<?php
 date_default_timezone_set('Asia/Bangkok');
include "../_lib/function/db_login.php";
//session_register("AVERIN_SESSION");

loadlib("class","AvObjects");
//loadlib("function","function.variabel");

if (!class_exists("Security")) {
	/**
	 * Class <code>Security</code>
	 */
	class Security extends AvObjects {

		/**
		 * indikasi bahwa user itu valid or gak
		 * @type boolean
		 */
		private $_validUser=false;
		private $_invalidPage="/err.php";

		/**
		 * constructor
		 * @param object $db Database object (AdoDB Object is the must!!!)
		 * @param string $userName Nama user
		 * @param string $userPass Passwordnya user
		 * @param string $bypass Kalo isinya "YES" berarti di-bypass (gak perlu pake password)
		 */

		 /*----------------------------*/
			
			/*-----------------------------*/

		public function __construct($db,$userName="",$userPass="",$bypass="",$kodeuser="") {
			parent::__construct();
			$this->_db = $db;
			$this->_validUser=false;

			if (($userName!="" && $userPass!="" && $kodeuser!="" ) || ($userName!="" && $bypass!="")) {
				//die("disini");
				$this->_cekUser($userName,$userPass,$bypass,$kodeuser);
			}

			
		}

		// ---- Private Methods ----------------------------------------------------------------------

		private function _cekUser($userName="",$userPass="",$bypass="") {
			// tambahan khusus untuk nyoba user
			
			
			if ($bypass=="YES") {
				$qry = "SELECT * FROM dd_user WHERE username='".$userName."' AND status=0";
			} else {
				
				$qry = "SELECT dd_user.*,mt_karyawan.url_foto_karyawan FROM dd_user LEFT JOIN mt_karyawan ON dd_user.no_induk = mt_karyawan.no_induk WHERE username='".$userName."' AND password='".md5($userPass)."' AND dd_user.status=0  ";
				
				
			}
			
			$result_id = $this->_db->Execute($qry);
			
			$this->_prop["userInfo"] = $this->InternalFetch($result_id);

			//$cnt=0;
			while ($check_user=$result_id->FetchRow()) {
				$this->_setValidUser();
				//$cnt++;
				//$template="kerangka.php";

				$sql_tutup_sblmnya="UPDATE log_user_login SET logoff_time='".date("Y-m-d G:i:s")."' WHERE logoff_time IS NULL AND session_id='".session_id()."'";

				$this->_db->Execute($sql_tutup_sblmnya);
				
				$sql_login="INSERT INTO log_user_login(id_dd_user,session_id,login_time,ip_address,ko_wil) VALUES (".$check_user["id_dd_user"].",'".session_id()."','".date("Y-m-d H:i:s")."','".USER_IP_ADDRESS."',".$check_user["ko_wil"].")";
				//echo $sql_login;
				$this->_db->Execute($sql_login);

				//$AVERIN_SESSION["username"]=$txt_name;
			}
		}

		private function _setValidUser($isFalse=false) {
			if (!$isFalse) {
				$this->_validUser=true;
			} else {
				$this->_validUser=false;
			}
		}

		// ---- Public Methods ----------------------------------------------------------------------

		public function hakModular() {
			if ($this->isValidUser()) {
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
			} else {
				die("Not valid User!!!");
			}
		}

		public function hakModul($modular="") {
			if ($this->isValidUser()) {
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
			} else {
				die("Not valid User!!!");
			}
		}

		public function hakMenu($modul) {
			if ($this->isValidUser()) {
				$menu=array();
				$t="admin_hak_user_v";
				$f="id_dc_menu";
				$o="WHERE id_dd_user=".$this->_prop["userInfo"]["id_dd_user"];
				$o.=" AND id_dc_modul=".$modul."";
				$o.=" GROUP BY id_dc_menu,nama_menu,id_dc_modul,no_urut_menu,no_urut_modul";
				$o.=" ORDER BY no_urut_modul,no_urut_menu";
				$qMenu="SELECT ".$f." FROM ".$t." ".$o;

				$rMenu=$this->_db->Execute($qMenu);
				while ($resMenu=$rMenu->FetchRow()) {
					$menu[]=$resMenu["id_dc_menu"];
				}
				return $menu;
			} else {
				die("Not valid User!!!");
			}
		}

		public function hakSubMenu($modul,$menu) {
			if ($this->isValidUser()) {
				$subMenu=array();
				$t="admin_hak_user_v";
				$f="id_dc_modul,id_dc_menu,id_dc_sub_menu,nama_sub_menu,url_sub_menu,hak_akses_menu AS hak_akses";
				$o="WHERE id_dd_user=".$this->_prop["userInfo"]["id_dd_user"];
				$o.=" AND id_dc_modul=".$modul." AND id_dc_menu=".$menu;
				$o.=" ORDER BY no_urut_sub_menu";
				$qSubMenu="SELECT ".$f." FROM ".$t." ".$o;

				// $qSubMenu="SELECT id_dc_modul,id_dc_menu,id_dc_sub_menu,nama_sub_menu,url_sub_menu,hak_akses_menu AS hak_akses FROM admin_hak_user_v WHERE id_dd_user=1 ORDER BY no_urut_modul,no_urut_menu,no_urut_sub_menu";


				$rSubMenu=$this->_db->Execute($qSubMenu);
				while ($resSubMenu=$rSubMenu->FetchRow()) {
					$subMenu[]=$resSubMenu["id_dc_sub_menu"];
				}
				return $subMenu;
			} else {
				die("Not valid User!!!");
			}
		}

		public function isLoggedIn($phpSessID="") {
			if ($phpSessID!="") {
				$t="log_user_login a,dd_user b";
				$f="username";
				$o="WHERE a.id_dd_user=b.id_dd_user AND logoff_time IS NULL";
				$o.=" AND session_id='".$phpSessID."'";
				$o.=" GROUP BY username";
				$q="SELECT ".$f." FROM ".$t." ".$o;
				$r=$this->_db->Execute($q);
				if ($r->_numOfRows>0) {
					while ($res=$r->FetchRow()) {
						//$this->_setValidUser();
						$userName=$res["username"];
						$this->__construct($this->_db,$userName,"","YES");
					}
				}
				return $this->isValidUser();
			} else {
				die("You must specify user's session ID!");
			}
		}

		public function isModulAllowed($modul) {
			if ($this->isValidUser()) {
				$allowedModul=$this->hakModul();
				return  in_array($modul,$allowedModul);
			} else {
				die("Not valid User!!!");
			}
		}

		public function isValidUser() {
			return $this->_validUser;
		}

		public function invalidPage() {
			header("Location: ".$this->_invalidPage);
		}
	}
}
?>
