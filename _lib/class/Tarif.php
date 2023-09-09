<?
include "AvObjects.php";
loadlib("function","function.submit_uang");
loadlib("function","function.pembulatan");

if (!class_exists("Tarif")) {
	class Tarif extends AvObjects {

		//-------------------------------------------------------------------

		/**
		 * Constructor
		 */
		public function __construct() {
			parent::__construct();

			global $db;
			$this->_db=$db;

			// Default nasabah, dianggep nasabah umum
			$this->_prop["kode_kelompok"]="1";

			// Default jumlah, 1
			$this->_prop["jumlah"]="1";

		} // end of public function __construct()

		//-------------------------------------------------------------------

		/**
		 * hitung() : Untuk menghitung tarif berdasarkan nasabahnya
		 *
		 * @return  array  Array berisi field-2 yang akan dimasukin ke tc_trans_pelayanan
		 *
		 */
		public function hitung() {
			$hasil=array();
			$inputnya=$this->getAllProp();
			$db=$this->_db;

			if (!function_exists("read_tabel")) { die("Tolong include library 'olah_tabel' donk.."); }

			if (!is_numeric($this->get("kode_klas")) || !is_numeric($this->get("jumlah"))
					|| !is_numeric($this->get("kode_tarif")) || !is_numeric($this->get("kode_kelompok"))) {

				die('DATA TARIF TIDAK DITEMUKAN / ATAU BELUM DIINPUT !<br/><input type="button" value="KEMBALI" onclick="javascript: window.history.back()" class="submit01">');
				/*
				if (function_exists("show")) show($this->getAllProp(),"Properti Object Tarif");
				die("Cek isi variabel 'kode_klas', 'jumlah', 'kode_kelompok', dan 'kode_tarif' donk..");
				*/
			}

			// kalo non-askes langsung dikasi 0 buat bill askes & jatah..
			switch ($this->get("kode_kelompok")) {
				case AV_KODE_NASABAH_UMUM :
				case AV_KODE_NASABAH_MEMBER :
				case AV_KODE_NASABAH_PERUSAHAAN :
				case AV_KODE_NASABAH_KARYAWAN :
				case AV_KODE_NASABAH_GAKIN :
					$tarifAskes=array();
					$tarifJatah=array();

					$tarifAskes["bill_rs_askes"] = "0";
					$tarifAskes["bill_dr1_askes"] = "0";
					$tarifAskes["bill_dr2_askes"] = "0";
					$tarifAskes["bill_dr3_askes"] = "0";

					$tarifJatah["bill_rs_jatah"] = "0";
					$tarifJatah["bill_dr1_jatah"] = "0";
					$tarifJatah["bill_dr2_jatah"] = "0";
					$tarifJatah["bill_dr3_jatah"] = "0";
					$tarifJatah["kode_master_tarif_detail_jatah"] = "";

					//echo "di dalam yg non-askes<br>\n";
					break;
				case AV_KODE_NASABAH_ASKES :
					$tarifAskes=$this->_hitungTarifAskes();
					$tarifJatah=$this->_hitungTarifJatah();
					break;
				default :
			}

			$tarifCurrent=$this->_hitungTarifCurrent();

			if (!is_array($inputnya)) $inputnya = array();
			if (!is_array($tarifCurrent)) $tarifCurrent = array();
			if (!is_array($tarifAskes)) $tarifAskes = array();
			if (!is_array($tarifJatah)) $tarifJatah = array();
			$hasil=array_merge($inputnya, $tarifCurrent, $tarifAskes, $tarifJatah);

			unset($this->_prop["cito"]);

			return $hasil;
		} // end of public function hitung()

		//-------------------------------------------------------------------

		/**
		 * hitungKonsultasi() : Untuk menghitung tarif konsultasi (jenis tindakan=12)
		 *                      Inputnya kode_bagian, kode_kelompok dan kode_klas
		 *
		 * @return  array  Tarif konsultasi utk kelas yang diambil pasien
		 *
		 */
		public function hitungKonsultasi() {
			if (!function_exists("baca_tabel")) { die("Tolong include library 'olah_tabel' donk.."); }

			if (!is_numeric($this->get("kode_klas")) || !is_numeric($this->get("kode_bagian"))) {
				if (function_exists("show")) show($this->getAllProp(),"Properti Object Tarif");
				die("Cek isi variabel 'kode_klas', dan 'kode_bagian' donk..");
			}

			$kode_tarif=baca_tabel("mt_tarif_v","kode_tarif","WHERE kode_bagian='".$this->get("kode_bagian")."' AND jenis_tindakan=12 AND kode_klas=".$this->get("kode_klas"));
			$this->set("kode_tarif",$kode_tarif);

			return $this->hitung();
		}

		//-------------------------------------------------------------------

		/**
		 * hitungSaranaRS() : Untuk menghitung tarif Sarana RS (jenis tindakan=13)
		 *                    Inputnya kode_bagian, kode_kelompok dan kode_klas
		 *
		 * @return  array  Tarif konsultasi utk kelas yang diambil pasien
		 *
		 */
		public function hitungSaranaRS() {
			if (!function_exists("baca_tabel")) { die("Tolong include library 'olah_tabel' donk.."); }

			if (!is_numeric($this->get("kode_klas")) || !is_numeric($this->get("kode_bagian"))) {
				if (function_exists("show")) show($this->getAllProp(),"Properti Object Tarif");
				die("Cek isi variabel 'kode_klas', dan 'kode_bagian' donk..");
			}

			$kode_tarif=baca_tabel("mt_tarif_v","kode_tarif","WHERE kode_bagian='".$this->get("kode_bagian")."' AND jenis_tindakan=13 AND kode_klas=".$this->get("kode_klas"));
			$this->set("kode_tarif",$kode_tarif);

			return $this->hitung();
		}

		//-------------------------------------------------------------------

		/**
		 * _hitungTarifCurrent() : Untuk menghitung tarif current
		 *
		 * @return  array  Tarif utk kelas yang diambil pasien (current)
		 *
		 */
		private function _hitungTarifCurrent() {
			$hasil=array();

			switch ($this->get("kode_kelompok")){
				case '1': //Cash
					$view_tarif = "mt_tarif_v";
				break;
				case '3': //Perusahaan
					$view_tarif = "mt_tarif_v";
					//$view_tarif = "mt_tarif_perusahaan_v";
				break;
				case '4': //Karyawan
					$view_tarif = "mt_tarif_v"; //data tidak ada, pake tarif umum !
				break;
				case '5': //Askes
					$view_tarif = "mt_tarif_v";
				break;
				case '6': //Gakin
					$view_tarif = "mt_tarif_v";
				break;
				default: //Cash
					$view_tarif = "mt_tarif_v";
			}

			$optTarif="WHERE kode_tarif=".$this->get("kode_tarif");
			$optTarif.=" AND kode_klas=".$this->get("kode_klas");
			$optTarif.=" AND status=1";

			/////////////////////////////////////////////////////////////////////////////
			$kobag=baca_tabel("mt_master_tarif","kode_bagian"," where  kode_tarif=".$this->get("kode_tarif"));
			
			
			
			$persen_klas=100;
			$kenaikan_klas=$persen_klas/100;
			
			
			/////////////////////////////////////////////////////////////////////////////

			/*if($this->get("kode_kelompok")=='3' && $this->get("acc_pola")!=''){
			$optTarif.=" AND acc_pola=".$this->get("acc_pola");
			}*/
			/////////////////////////////////////////////////////////////////////////////
		    // $db->debug=true;
			//$rTarif=read_tabel("mt_tarif_v","bill_rs,bill_dr1,bill_dr2,kode_master_tarif_detail,nama_tarif,jenis_tindakan",$optTarif);

			$rTarif=read_tabel($view_tarif, "bill_rs, bill_dr1, alat_rs, overhead, pendapatan_rs, kode_tarif as kode_master_tarif_detail, nama_tarif, jenis_tindakan", $optTarif);

			
			
			//if (isset($this->_prop["cito"]) && ($this->get("cito")!="" || $this->get("cito")!="0")) {
			//jika paket silver
			if($kobag=='050101' || $kobag=='050201' || $kobag=='050301'){
								if (isset($this->_prop["cito"]) && ($this->get("cito")=="1")) {
					
					//$hasil=$this->_hitungTarifCito($rTarif->fields);
					$hasil_cito=$this->_hitungTarifCito($rTarif->Fields("bill_rs"),$rTarif->Fields("bill_dr1"),$rTarif->Fields("bill_dr2"),$rTarif->Fields("bill_dr3"),$rTarif->Fields("bill_perawat"),$rTarif->Fields("kamar_tindakan"),$rTarif->Fields("biaya_lain"),$rTarif->Fields("obat"),$rTarif->Fields("alkes"),$rTarif->Fields("alat_rs"),$rTarif->Fields("adm"),$rTarif->Fields("overhead"),$rTarif->Fields("bhp"),$rTarif->Fields("pendapatan_rs"),$rTarif->Fields("pendapatan_rsop"),$rTarif->Fields("pendapatan_rsan"),$rTarif->Fields("gros_operator1"));

					$hasil["bill_rs"] 			= 0;
					$hasil["bill_dr1"] 			= 0;
					$hasil["bill_dr2"] 			= 0;
					$hasil["bill_dr3"] 			= 0;
					$hasil["bill_perawat"] 		= 0;
					$hasil["kamar_tindakan"] 	= 0;
					$hasil["biaya_lain"] 		= 0;
					$hasil["obat"] 				= 0;
					$hasil["alkes"] 			= 0;
					$hasil["alat_rs"] 			= 0;
					$hasil["adm"] 				= 0;
					$hasil["bhp"] 				= 0;
					$hasil["pendapatan_rs"] 	= 0;
					$hasil["gros_dr"] 			= 0;
					$hasil["pendapatan_rsan"] 	= 0;
					$hasil["pendapatan_rsop"] 	= 0;
					
					
				} else {
					
					
					$hasil["bill_rs"] 			= 0;
					$hasil["bill_dr1"] 			= 0;
					$hasil["bill_dr3"] 			= 0;
					$hasil["bill_perawat"] 		= 0;
					$hasil["kamar_tindakan"] 	= 0;
					$hasil["biaya_lain"] 		= 0;
					$hasil["obat"] 				= 0;
					$hasil["alkes"] 			= 0;
					$hasil["alat_rs"] 			= 0;
					$hasil["adm"] 				= 0;
					$hasil["overhead"] 			= 0;
					$hasil["bhp"] 				= 0;
					$hasil["pendapatan_rs"] 	= 0;
					$hasil["harga_dasar"] 		= 0;
					$hasil["pendapatan_rsan"] 	= 0;
					$hasil["pendapatan_rsop"] 	= 0;
					$hasil["gros_dr"] 			= 0;
					$hasil["konsul"] 			= 0;
					$hasil["sewa_alat"] 		= 0;
					$hasil["ambhp"] 			= 0;
					$hasil["paramedis"] 		= 0;
					$hasil["sewa_kamar"] 		= 0;
					$hasil["observasi_ok"] 		= 0;
					

					
				}


				
			}else{
				if (isset($this->_prop["cito"]) && ($this->get("cito")=="1")) {
					
					//$hasil=$this->_hitungTarifCito($rTarif->fields);
					$hasil_cito=$this->_hitungTarifCito($rTarif->Fields("bill_rs"),$rTarif->Fields("bill_dr1"),$rTarif->Fields("bill_dr2"),$rTarif->Fields("bill_dr3"),$rTarif->Fields("bill_perawat"),$rTarif->Fields("kamar_tindakan"),$rTarif->Fields("biaya_lain"),$rTarif->Fields("obat"),$rTarif->Fields("alkes"),$rTarif->Fields("alat_rs"),$rTarif->Fields("adm"),$rTarif->Fields("overhead"),$rTarif->Fields("bhp"),$rTarif->Fields("pendapatan_rs"),$rTarif->Fields("pendapatan_rsop"),$rTarif->Fields("pendapatan_rsan"),$rTarif->Fields("gros_operator1"));

					$hasil["bill_rs"] 			= $hasil_cito["bill_rs"]*$kenaikan_klas;
					$hasil["bill_dr1"] 			= $hasil_cito["bill_dr1"]*$kenaikan_klas;
					$hasil["bill_dr2"] 			= $hasil_cito["bill_dr2"]*$kenaikan_klas;
					$hasil["bill_dr3"] 			= $hasil_cito["bill_dr3"]*$kenaikan_klas;
					$hasil["bill_perawat"] 		= $hasil_cito["bill_perawat"]*$kenaikan_klas;
					$hasil["kamar_tindakan"] 	= $hasil_cito["kamar_tindakan"]*$kenaikan_klas;
					$hasil["biaya_lain"] 		= $hasil_cito["biaya_lain"]*$kenaikan_klas;
					$hasil["obat"] 				= $hasil_cito["obat"]*$kenaikan_klas;
					$hasil["alkes"] 			= $hasil_cito["alkes"]*$kenaikan_klas;
					$hasil["alat_rs"] 			= $hasil_cito["alat_rs"]*$kenaikan_klas;
					$hasil["adm"] 				= $hasil_cito["adm"]*$kenaikan_klas;
					$hasil["bhp"] 				= $hasil_cito["bhp"]*$kenaikan_klas;
					$hasil["pendapatan_rs"] 	= $hasil_cito["pendapatan_rs"]*$kenaikan_klas;
					$hasil["gros_dr"] 			= $hasil_cito["gros_operator1"]*$kenaikan_klas;
					$hasil["pendapatan_rsan"] 	= $hasil_cito["pendapatan_rsan"]*$kenaikan_klas;
					$hasil["pendapatan_rsop"] 	= $hasil_cito["pendapatan_rsop"]*$kenaikan_klas;
					
					
				} else {
					
					
					$hasil["bill_rs"] 			= ($rTarif->fields['bill_rs']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["bill_dr1"] 			= ($rTarif->fields['bill_dr1']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["bill_dr3"] 			= ($rTarif->fields['bill_dr3']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["bill_perawat"] 		= ($rTarif->Fields("bill_perawat")*$kenaikan_klas) * $this->get("jumlah");
					$hasil["kamar_tindakan"] 	= ($rTarif->fields['kamar_tindakan']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["biaya_lain"] 		= ($rTarif->fields['biaya_lain']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["obat"] 				= ($rTarif->fields['obat']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["alkes"] 			= ($rTarif->fields['alkes']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["alat_rs"] 			= ($rTarif->fields['alat_rs']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["adm"] 				= ($rTarif->fields['adm']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["overhead"] 			= ($rTarif->fields['overhead']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["bhp"] 				= ($rTarif->fields['bhp']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["pendapatan_rs"] 	= ($rTarif->fields['pendapatan_rs']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["harga_dasar"] 		= ($rTarif->fields['harga_dasar']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["pendapatan_rsan"] 	= ($rTarif->fields['pendapatan_rsan']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["pendapatan_rsop"] 	= ($rTarif->fields['pendapatan_rsop']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["gros_dr"] 			= ($rTarif->fields['gros_operator1']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["konsul"] 			= ($rTarif->fields['konsul']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["sewa_alat"] 		= ($rTarif->fields['sewa_alat']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["ambhp"] 			= ($rTarif->fields['ambhp']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["paramedis"] 		= ($rTarif->fields['paramedis']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["sewa_kamar"] 		= ($rTarif->fields['sewa_kamar']*$kenaikan_klas) * $this->get("jumlah");
					$hasil["observasi_ok"] 		= ($rTarif->fields['observasi_ok']*$kenaikan_klas) * $this->get("jumlah");
					

					
				}
			
			}

			$hasil["kode_master_tarif_detail"] = $rTarif->fields['kode_master_tarif_detail'];
			$hasil["nama_tindakan"] = $rTarif->fields['nama_tarif'];
			$hasil["jenis_tindakan"] = $rTarif->fields['jenis_tindakan'];

			return $hasil;
		} // end of private function _hitungTarifCurrent()

		//-------------------------------------------------------------------

		/**
		 * _hitungTarifAskes() : Untuk menghitung tarif yang akan dibayar askes
		 *
		 * @return  array  Penjelasannya
		 *
		 */
		private function _hitungTarifAskes() {
			$hasil=array();
			//echo "dalam _hitungTarifAskes()<br>\n";

			$hasil["bill_rs_askes"] = "0";
			$hasil["bill_dr1_askes"] = "0";
			$hasil["bill_dr2_askes"] = "0";
			$hasil["bill_dr3_askes"] = "0";

			return $hasil;
		} // end of private function _hitungTarifAskes()

		//-------------------------------------------------------------------

		/**
		 * _hitungTarifJatah() : Untuk menghitung tarif jatah
		 *
		 * @return  array  Penjelasannya
		 *
		 */
		private function _hitungTarifJatah() {
			$hasil=array();

			$hasil["bill_rs_jatah"] = "0";
			$hasil["bill_dr1_jatah"] = "0";
			$hasil["bill_dr2_jatah"] = "0";
			$hasil["bill_dr3_jatah"] = "0";
			$hasil["kode_master_tarif_detail_jatah"] = "";

			return $hasil;
		} // end of private function _hitungTarifJatah()

		//-------------------------------------------------------------------

		/**
		 * _hitungTarifCito() : Untuk menghitung tarif cito
		 *
		 * @param  numerik  $bill_rs  Penjelasannya
		 * @param  numerik  $bill_dr1  Penjelasannya
		 * @param  numerik  $bill_dr2  Penjelasannya
		 * @param  numerik  $bill_dr3  Penjelasannya
		 *
		 * @return  array  Penjelasannya
		 *
		 */
		private function _hitungTarifCito($params,$bill_dr1,$bill_dr2,$bill_dr3,$bill_perawat,$kamar_tindakan,$biaya_lain,$obat,$alkes,$alat_rs,$adm,$overhead,$bhp,$pendapatan_rs) {
		
			$hasil=array();

			if (!function_exists("baca_tabel")) { die("Tolong include library 'olah_tabel' donk.."); }
			
			if (!is_numeric($this->get("kode_bagian"))) {
				if (function_exists("show")) show($this->getAllProp(),"Properti Object Tarif");
				die("Cek isi variabel 'kode_bagian' donk..");
			}

			$nilai_cito=baca_tabel("pm_mt_kenaikancito","prosentase","WHERE kode_bagian='".$this->get("kode_bagian")."'");
			$kenaikan_cito = ($nilai_cito * 0.01) + 1;
			
			$bill_rs=$params * $kenaikan_cito;
			$bill_dr1=$bill_dr1 * $kenaikan_cito;
			$bill_dr2=$bill_dr2 * $kenaikan_cito;
			$bill_dr3=$bill_dr3 * $kenaikan_cito;
			$bill_perawat=$bill_perawat * $kenaikan_cito;
			$kamar_tindakan=$kamar_tindakan * $kenaikan_cito;
			$biaya_lain=$biaya_lain * $kenaikan_cito;
			$obat=$obat * $kenaikan_cito;
			$alkes=$alkes * $kenaikan_cito;
			$obat=$obat * $kenaikan_cito;
			$alat_rs=$alat_rs * $kenaikan_cito;
			$adm=$adm * $kenaikan_cito;
			$overhead=$overhead * $kenaikan_cito;
			$bhp=$bhp * $kenaikan_cito;
			$pendapatan_rs=$pendapatan_rs * $kenaikan_cito;
			
			$hasil["bill_rs"] = ceil($bill_rs) ;
			$hasil["bill_dr1"] = ceil($bill_dr1);
			$hasil["bill_dr2"] = ceil($bill_dr2);
			$hasil["bill_dr3"] = ceil($bill_dr3);
			$hasil["bill_perawat"] = ceil($bill_perawat);
			$hasil["kamar_tindakan"] = ceil($kamar_tindakan);
			$hasil["biaya_lain"] = ceil($biaya_lain);
			$hasil["obat"] = ceil($obat);
			$hasil["alkes"] = ceil($alkes);
			$hasil["alat_rs"] = ceil($alat_rs);
			$hasil["adm"] = ceil($adm);
			$hasil["overhead"] = ceil($overhead);
			$hasil["bhp"] = ceil($bhp);
			$hasil["pendapatan_rs"] = ceil($pendapatan_rs);

			return $hasil;
		} // end of private function _hitungTarifCito()

		//-------------------------------------------------------------------

		/**
		 * hitungBPAKO() : Untuk menghitung tarif BPAKO
		 *
		 * @param  tipenya  $variabelnya  Penjelasannya
		 *
		 * @return  array  Penjelasannya
		 *
		 */
		public function hitungBPAKO() {
			$hasil=array();
			$inputnya=$this->getAllProp();
			$db=$this->_db;

			if (!function_exists("baca_tabel")) { die("Tolong include library 'olah_tabel' donk.."); }
			
			if (!is_string($this->get("kode_barang"))) {
				if (function_exists("show")) show($this->getAllProp(),"Properti Object Tarif");
				die("Cek isi variabel 'kode_barang' donk..");
			}

			// kalo non-askes langsung dikasi 0 buat bill askes & jatah..
			switch ($this->get("kode_kelompok")) {
				case AV_KODE_NASABAH_UMUM :
				case AV_KODE_NASABAH_MEMBER :
				case AV_KODE_NASABAH_PERUSAHAAN :
				case AV_KODE_NASABAH_KARYAWAN :
				case AV_KODE_NASABAH_GAKIN :
					$tarifAskes=array();
					$tarifJatah=array();

					$tarifAskes["bill_rs_askes"] = "0";
					$tarifAskes["bill_dr1_askes"] = "0";
					$tarifAskes["bill_dr2_askes"] = "0";
					$tarifAskes["bill_dr3_askes"] = "0";

					$tarifJatah["bill_rs_jatah"] = "0";
					$tarifJatah["bill_dr1_jatah"] = "0";
					$tarifJatah["bill_dr2_jatah"] = "0";
					$tarifJatah["bill_dr3_jatah"] = "0";

					//echo "di dalam yg non-askes<br>\n";
					break;
				case AV_KODE_NASABAH_ASKES :
					$tarifAskes=$this->_hitungTarifAskes();
					$tarifJatah=$this->_hitungTarifJatah();
					break;
				default :
			}

			$tarifCurrent=$this->_hitungBPAKOCurrent();

			if (!is_array($inputnya)) $inputnya = array();
			if (!is_array($tarifCurrent)) $tarifCurrent = array();
			if (!is_array($tarifAskes)) $tarifAskes = array();
			if (!is_array($tarifJatah)) $tarifJatah = array();
			$hasil=array_merge($inputnya, $tarifCurrent, $tarifAskes, $tarifJatah);

			$hasil["jenis_tindakan"]="9";
			$hasil["nama_tindakan"]=baca_tabel("mt_barang","nama_brg","WHERE kode_brg='".$this->get("kode_barang")."'");

			return $hasil;
		} // end of public function hitungBPAKO()

		//-------------------------------------------------------------------

		/**
		 * hitungBPAKOCurrent() : Untuk menghitung tarif cito
		 *
		 * @param  tipenya  $variabelnya  Penjelasannya
		 *
		 * @return  array  Penjelasannya
		 *
		 */
		private function _hitungBPAKOCurrent() {
			$hasil=array();

			$rBPAKO=read_tabel("mt_rekap_stok","harga_beli","WHERE kode_brg='".$this->get("kode_barang")."'");

			$kategori=substr($this->get("kode_barang"),0,1);
			$kode_kelompok=$this->get("kode_kelompok");
			$flag_kjs=baca_tabel("mt_barang","flag_kjs","where kode_brg='".$this->get("kode_barang")."'");
			if ($kategori=="D") { 
				//Nantinya di hitung berdasarkan layanannya juga.
				$nilai_profit = baca_tabel("fr_mt_profit_margin", "profit_obat", "WHERE kode_profit=".$this->get("kode_profit")." AND tingkat=1");
				
				/*Untuk rssm margin di hitung perobatnya belum ada standar sementara pakai ini*/
				if(($kode_kelompok=='10') &&($flag_kjs=='10')){
					$cek_nilai_profit=baca_tabel("fr_mt_profit_margin","profit_obat","WHERE kode_profit=10007");
					if($cek_nilai_profit!=''){
						$nilai_profit=$cek_nilai_profit;
					}else{

						$id_profit		=baca_tabel("mt_rekap_stok","id_profit","where  kode_brg='".$this->get("kode_barang")."'");
							if($id_profit!=""){
								$nilai_profit	=baca_tabel("fr_mt_profit_margin","profit_obat","WHERE id_profit=".$id_profit);
							}
					}
				}else{
					$id_profit		=baca_tabel("mt_rekap_stok","id_profit","where  kode_brg='".$this->get("kode_barang")."'");
					if($id_profit!=""){
						$nilai_profit	=baca_tabel("fr_mt_profit_margin","profit_obat","WHERE id_profit=".$id_profit);
					}
				}


			} elseif ($kategori=="E") {

				$nilai_profit = baca_tabel("fr_mt_profit_margin", "profit_alkes", "WHERE kode_profit=".$this->get("kode_profit")." AND tingkat=1");
				if(($kode_kelompok=='10') &&($flag_kjs=='10')){
					$cek_nilai_profit=baca_tabel("fr_mt_profit_margin","profit_alkes","WHERE kode_profit=10007");

					if($cek_nilai_profit!=''){
						$nilai_profit=$cek_nilai_profit;
					}else{

						$id_profit		=baca_tabel("mt_rekap_stok","id_profit","where  kode_brg='".$this->get("kode_barang")."'");
							if($id_profit!=""){
								$nilai_profit	=baca_tabel("fr_mt_profit_margin","profit_obat","WHERE id_profit=".$id_profit);
							}
					}


				}else{
				/*Untuk rssm margin di hitung perobatnya belum ada standar sementara pakai ini*/

					$id_profit		=baca_tabel("mt_rekap_stok","id_profit","where  kode_brg='".$this->get("kode_barang")."'");
					if($id_profit!=""){
						$nilai_profit	=baca_tabel("fr_mt_profit_margin","profit_alkes","WHERE id_profit=".$id_profit);
					}
				}

			}
		
			$kenaikan_profit = ($nilai_profit*0.01)+1;

			

			if (is_numeric($rBPAKO->fields['harga_beli']) && is_numeric($this->get("jumlah"))) {
				$hasil["bill_rs"] = ceil($rBPAKO->fields['harga_beli'] * $kenaikan_profit * $this->get("jumlah"));
				$kode_kelompok=$this->get("kode_kelompok");
				if($kode_kelompok=='10'){
					if($flag_kjs=='10'){
						$hasil["bill_kjs"] = ceil($rBPAKO->fields['harga_beli'] * $kenaikan_profit * $this->get("jumlah"));
						$hasil["bill_bs_rs"] = "";
					}else{
						$hasil["bill_bs_rs"] = ceil($rBPAKO->fields['harga_beli'] * $kenaikan_profit * $this->get("jumlah"));
						$hasil["bill_kjs"] = "";
					}
				}else{
					$hasil["bill_kjs"] = "";
					$hasil["bill_bs_rs"] = "";
				}
			} else {
				$hasil["bill_rs"] = "0";
			}
			$hasil["bill_dr1"]="0";
			$hasil["bill_dr2"]="0";
			$hasil["bill_dr3"]="0";

			return $hasil;
		} // end of public function _hitungBPAKOCurrent()

		//-------------------------------------------------------------------

		/**
		 * BELOM JADI !!!
		 *
		 * hitungFarmasi() : Untuk menghitung tarif farmasi
		 *
		 * @param  tipenya  $variabelnya  Penjelasannya
		 *
		 * @return  array  Penjelasannya
		 *
		 */
		public function hitungFarmasi() {
			$hasil=array();

			$rBPAKO=read_tabel("mt_rekap_stok","harga_beli","WHERE kode_brg='".$this->get("kode_barang")."'");

			if (is_numeric($rBPAKO->fields['harga_beli']) && is_numeric($this->get("jumlah"))) {
				$hasil["bill_rs"] = $rBPAKO->fields['harga_beli'] * $this->get("jumlah");
			} else {
				$hasil["bill_rs"] = "0";
			}
			$hasil["bill_dr1"]="0";
			$hasil["bill_dr2"]="0";
			$hasil["bill_dr3"]="0";

			return $hasil;
		} // end of public function _hitungBPAKOCurrent()

		//-------------------------------------------------------------------

	} // end of class Tarif
}
?>