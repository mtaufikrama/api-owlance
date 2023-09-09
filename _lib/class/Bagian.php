<?
include "AvObjects.php";

if (!class_exists("Bagian")) {
	class Bagian extends AvObjects {
		public function __construct($db,$kdBag) {
			parent::__construct();
		} // end of public function __construct($db,$kdBag)
	} // end of class Bagian extends AvObjects
}
?>