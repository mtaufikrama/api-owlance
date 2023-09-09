<?
include "AvObjects.php";
include "Barang.php";

if (!class_exists("BarangDepo")) {
	class BarangDepo extends AvObjects {

		// ---------------------------------------------------------------------------------

		/**
		 * Constructor
		 */
		public function __construct($kodeBarang="",$kodeBagian="") {
		} // end of public function __construct($kodeBarang="",$kodeBagian="")

		// ---------------------------------------------------------------------------------

		/**
		 * set() : Overrides set() function on parent class
		 *
		 * @param  string  $theProp  Nama properti yang akan diubah nilainya
		 * @param  mixed  $newValue  Isi variabel yang baru
		 *
		 */
		public function set($theProp,$newValue) {
		} // end of public function set($theProp,$newValue)

		// ---------------------------------------------------------------------------------

		/**
		 * _setDepoBarang() : 
		 *
		 * @param  string  $kodeBarang  Kode barang yang baru
		 * @param  string  $kodeBagian  Kode bagian yang baru
		 *
		 */
		private function _setDepoBarang($kodeBarang,$kodeBagian) {
			$this->clear();

			$rBrg=read_tabel("mt_depo_stok_v","*","WHERE kode_brg='".$kodeBarang."' AND kode_bagian='".$kodeBagian."'");
			$this->_prop=$this->InternalFetch($rBrg);
		} // end of private function _setDepoBarang($kodeBarang,$kodeBagian)

		// ---------------------------------------------------------------------------------

	} // end of if (!class_exists("BarangDepo"))
} // end of class BarangDepo extends AvObjects
?>