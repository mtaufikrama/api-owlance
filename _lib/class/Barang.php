<?
include "AvObjects.php";
//loadlib("function","function.variabel");
loadlib("function","function.olah_tabel");
loadlib("function","function.max_kode_number");
if (!class_exists("Barang")) {
	class Barang extends AvObjects {

		// ---------------------------------------------------------------------------------

		/**
		 * Constructor
		 */
		public function __construct($kodeBarang="") {
			parent::__construct();

			global $db;
			$this->_db=$db;

			if ($kodeBarang!="") {
				$this->_setKodeBarang($kodeBarang);
			}
		} // end of public function __construct($kodeBarang)

		// ---------------------------------------------------------------------------------

		/**
		 * set() : Overrides set() function on parent class
		 *
		 * @param  string  $theProp  Nama properti yang akan diubah nilainya
		 * @param  mixed  $newValue  Isi variabel yang baru
		 *
		 */
		public function set($theProp,$newValue) {
			if ($theProp=="kode_brg" && $newValue!="") {
				$this->_setKodeBarang($newValue);
			} else {
				parent::set($theProp,$newValue);
			}
		} // end of public function set($theProp,$newValue)

		// ---------------------------------------------------------------------------------

		/**
		 * _setKodeBarang() : 
		 *
		 * @param  string  $kodeBarang  Kode barang yang baru
		 *
		 */
		public function _setKodeBarang($kodeBarang) {
			$this->clear();

			$rBrg=read_tabel("mt_barang","*","WHERE kode_brg='".$kodeBarang."'");
			$this->_prop=$this->InternalFetch($rBrg);
		} // end of private function _setKodeBarang($kodeBarang)

		// ---------------------------------------------------------------------------------

		/**
		 * tambah_depo_stok() : 
		 *
		 * @param  string  $kodeBrg  
		 * @param  string  $jumlah  
		 * @param  string  $kodeBagian  
		 *
		 */
		public function tambah_depo_stok($kodeBrg,$jumlah,$kodeBagian) {
			if (is_numeric($jumlah)) {
				$jml_sat_kcl=baca_tabel("mt_depo_stok","jml_sat_kcl","WHERE kode_brg='".$kodeBrg."'");
				$jml_sat_kcl_sekarang = $jml_sat_kcl + $jumlah;

				$fld=array();
				$fld["jml_sat_kcl"] = $jml_sat_kcl_sekarang;
				update_tabel("mt_depo_stok",$fld,"WHERE kode_brg='".$kodeBrg."'");
			}
		} // end of public function tambah_depo_stok($kodeBrg,$jumlah,$kodeBagian)

		// ---------------------------------------------------------------------------------

		/**
		 * kurang_depo_stok() : 
		 *
		 * @param  string  $kodeBrg  
		 * @param  string  $jumlah  
		 * @param  string  $kodeBagian  
		 *
		 */
		public function kurang_depo_stok($kodeBrg,$jumlah,$kodeBagian) {
			if (is_numeric($jumlah)) {
				$jml_sat_kcl=baca_tabel("mt_depo_stok","jml_sat_kcl","WHERE kode_brg='".$kodeBrg."'");
				$jml_sat_kcl_sekarang = $jml_sat_kcl - $jumlah;

				$fld=array();
				$fld["jml_sat_kcl"] = $jml_sat_kcl_sekarang;
				update_tabel("mt_depo_stok",$fld,"WHERE kode_brg='".$kodeBrg."'");
			}
		} // end of public function kurang_depo_stok($kodeBrg,$jumlah,$kodeBagian)

		// ---------------------------------------------------------------------------------

		/**
		 * tambah_kartu_stok() : 
		 *
		 * @param  string  $kodeBrg  
		 * @param  string  $jumlah  
		 * @param  string  $kodeBagian  
		 * @param  string  $jenisKartuStok  
		 * @param  string  $keterangan  
		 *
		 */
		public function tambah_kartu_stok($kodeBrg,$jumlah,$kodeBagian,$jenisKartuStok,$keterangan="") {
			if (is_numeric($jumlah)) {
				global $loginInfo;
				$jml_sat_kcl=baca_tabel("mt_depo_stok","jml_sat_kcl","WHERE kode_brg='".$kodeBrg."'");
				$jml_sat_kcl_sekarang = $jml_sat_kcl + $jumlah;
				$id_kartu=max_kode_number("tc_kartu_stok","id_kartu");
				$petugas=$loginInfo["no_induk"];
				$tgl_input = date("Y-m-d H:i:s");
				$ket=baca_tabel("mt_jenis_kartu_stok","nama_jenis","WHERE jenis_transaksi=".$jenisKartuStok)."; ";
				if ($keterangan!="") $ket.=" ".$keterangan;

				$fld=array();
				$fld["id_kartu"] = $id_kartu;
				$fld["kode_brg"] = $kodeBrg;
				$fld["stok_awal"] = $jml_sat_kcl;
				$fld["pemasukan"] = $jumlah;
				$fld["pengeluaran"] = "0";
				$fld["stok_akhir"] = $jml_sat_kcl_sekarang;
				$fld["jenis_transaksi"] = $jenisKartuStok;
				// $fld["kode_bagian"] = $kodeBagian;
				$fld["keterangan"] = $ket;
				$fld["petugas"] = $petugas;
				$fld["tgl_input"]= $tgl_input;
				$fld["harga_beli"]= baca_tabel("mt_rekap_stok","harga_beli","WHERE kode_brg='".$kodeBrg."'");
				insert_tabel("tc_kartu_stok",$fld);
			}
		} // end of public function tambah_kartu_stok($kodeBrg,$jumlah,$kodeBagian)

		// ---------------------------------------------------------------------------------

		/**
		 * kurang_kartu_stok() : 
		 *
		 * @param  string  $kodeBrg  
		 * @param  string  $jumlah  
		 * @param  string  $kodeBagian  
		 * @param  string  $jenisKartuStok  
		 * @param  string  $keterangan  
		 *
		 */
		public function kurang_kartu_stok($kodeBrg,$jumlah,$kodeBagian,$jenisKartuStok,$keterangan="") {
			if (is_numeric($jumlah)) {
				global $loginInfo;
				$jml_sat_kcl=baca_tabel("mt_depo_stok","jml_sat_kcl","WHERE kode_brg='".$kodeBrg."'");
				$jml_sat_kcl_sekarang = $jml_sat_kcl - $jumlah;
				$id_kartu=max_kode_number("tc_kartu_stok","id_kartu");
				$petugas=$loginInfo["no_induk"];
				$tgl_input = date("Y-m-d H:i:s");
				$ket=baca_tabel("mt_jenis_kartu_stok","nama_jenis","WHERE jenis_transaksi=".$jenisKartuStok)."; ";
				if ($keterangan!="") $ket.=" ".$keterangan;

				$fld=array();
				$fld["id_kartu"] = $id_kartu;
				$fld["kode_brg"] = $kodeBrg;
				$fld["stok_awal"] = $jml_sat_kcl;
				$fld["pemasukan"] = "0";
				$fld["pengeluaran"] = $jumlah;
				$fld["stok_akhir"] = $jml_sat_kcl_sekarang;
				$fld["jenis_transaksi"] = $jenisKartuStok;
				// $fld["kode_bagian"] = $kodeBagian;
				$fld["keterangan"] = $ket;
				$fld["petugas"] = $petugas;
				$fld["tgl_input"]= $tgl_input;
				$fld["harga_beli"]= baca_tabel("mt_rekap_stok","harga_beli","WHERE kode_brg='".$kodeBrg."'");
				insert_tabel("tc_kartu_stok",$fld);
			}
		} // end of public function kurang_kartu_stok($kodeBrg,$jumlah,$kodeBagian)

		// ---------------------------------------------------------------------------------

		// ---------------------------------------------------------------------------------

		// ---------------------------------------------------------------------------------

		// ---------------------------------------------------------------------------------

	} // end of class Barang extends AvObjects
}
?>