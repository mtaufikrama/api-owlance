<?
include "AvObjects.php";

if (!class_exists("Pasien")) {
	class Pasien extends AvObjects {

		public function __construct($db,$noMR) {
			parent::__construct();

			if ($noMR!="") {
				$q = "SELECT * FROM pl_mt_pasien_v WHERE no_mr='".$noMR."'";
				$r = $db->Execute($q) or die("Query Gagal<br>\n".$q);
				for ($i=0; $i<$r->FieldCount(); $i++) {
					//print_r($r->FetchField($i));
					$fld = $r->FetchField($i);
					$fldName = $fld->name;
					$isi = $r->Fields($fldName);
					$this->_prop[$fldName] = $isi;
				}
			}
			$this->_db = $db;
		} // end of public function __construct($db,$noMR)

		// Overrides set() function on parent class
		public function set($theProp,$newValue) {
			if ($theProp=="no_mr" && $newValue!="") {
				$this->__construct($this->_db,$newValue);
			} else {
				$this->_prop[$theProp] = $newValue;
			}
		}
	} // end of class Pasien extends AvObjects
}
?>