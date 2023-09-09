<?
include "AvObjects.php";
include "Pasien.php";

if (!class_exists("PasienPoli")) {
	class PasienPoli extends Pasien {
		private $kdPoli;
		private $kdBag;

		public function __construct($db,$kdPoli) {
			

			parent::__construct($db,$noMR);
		} // end of constructor
	} // end of class PasienPoli extends Pasien
} // end of if (!class_exists("PasienPoli"))
?>