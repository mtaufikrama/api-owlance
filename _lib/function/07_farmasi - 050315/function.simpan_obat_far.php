<?
require_once("../_lib/function/db.php");
loadlib("function","function.olah_tabel");
loadlib("function","function.max_kode_number");




// =================================== menghitung profit margin ============================================//


function profit_margin($kode_profit,$kode_brg,$klasnya="")
{
	global $db;
	///////////////////variabel///////////////
	$kategori=substr($kode_brg,0,1);
	
	if($kategori=="D")
	{
		//Nantinya di hitung berdasarkan layanannya juga.
		if($klasnya=="") {
			$nilai_profit=baca_tabel("fr_mt_profit_margin","profit_obat","WHERE kode_profit=".$kode_profit." and tingkat=1");
		}else{
			$nilai_profit=baca_tabel("fr_mt_profit_margin","profit_obat","WHERE  tingkat=1 and kode_klas=".$klasnya);
		}
		
		/*Untuk rssm margin di hitung perobatnya belum ada standar  pakai ini*/

		/*$id_profit		=baca_tabel("mt_rekap_stok","id_profit","where kode_brg='".$kode_brg."'");

		if($id_profit!=""){
			$nilai_profit	=baca_tabel("fr_mt_profit_margin","profit_obat","WHERE id_profit=".$id_profit);
		}*/



	}elseif($kategori=="E")
	{
		//$nilai_profit=baca_tabel("fr_mt_profit_margin","profit_alkes","WHERE kode_profit=".$kode_profit." and tingkat=1");

		/*Untuk rssm margin di hitung perobatnya belum ada standar  pakai ini*/

		/*$id_profit		=baca_tabel("mt_rekap_stok","id_profit","where kode_brg='".$kode_brg."'");
		if($id_profit!=""){
			$nilai_profit	=baca_tabel("fr_mt_profit_margin","profit_alkes","WHERE id_profit=".$id_profit);
		}*/

		if($klasnya=="") {
			$nilai_profit=baca_tabel("fr_mt_profit_margin","profit_alkes","WHERE kode_profit=".$kode_profit." and tingkat=1");
		}else{
			$nilai_profit=baca_tabel("fr_mt_profit_margin","profit_alkes","WHERE  tingkat=1 and kode_klas=".$klasnya);
		}

	}


	
	$kenaikan_profit=($nilai_profit*0.01)+1;
	return $kenaikan_profit;
}

// =================================== menghitung harga_beli,harga_jual ============================================//

function harga_far($kode_profit,$kode_bagian,$no_mr="",$txt_kd_brg,$klasnya="")
{
	global $db;

	$_sqlo = "select * from mt_depo_stok as a , mt_rekap_stok as b where a.kode_brg=b.kode_brg and a.kode_bagian='".$kode_bagian."' and a.kode_brg='".$txt_kd_brg."'";
	
	$sqlo=&$db->Execute($_sqlo);
	$harga_beli=$sqlo->fields["harga_beli"];

	$besar_profit=profit_margin($kode_profit,$txt_kd_brg,$klasnya);
	$harga_jual=ceil($harga_beli * $besar_profit);
	/*add baru*/
	/*$_sqloPPN = "select * from fr_mt_profit_margin where kode_profit=".$kode_profit;
	$sqloPPN=&$db->Execute($_sqloPPN);
	$PPN=$sqloPPN->fields["ppn"];
	$harga_jual_ppn=$PPN/100*$harga_jual;
	$harga_jual=$harga_jual + $harga_jual_ppn;*/

	
	$arrReturn["harga_beli"]=$harga_beli;
	$arrReturn["harga_jual"]=$harga_jual;
	$arrReturn["besar_profit"]=$besar_profit;
	return $arrReturn;


}

// =================================== menginput transaksi ke tabel fr_tc_far ============================================//

function ambil_nomor_far($kode_profit,$kode_pesan_resep,$kode_bagian,$kode_bagian_asal,$no_registrasi,$kode_dokter,$no_mr,$txt_dokter_pengirim,$txt_nama_pasien,$txt_telp,$txt_alamat,$no_kunjungan,$petugas)
{
	global $db;

	$thn = date("Y");
	$bln = date("m");
	$tgl = date("d");

	//$kode_trans_far = max_kode_number("fr_tc_far","kode_trans_far","where kode_bagian='".$kode_bagian."'");
	$kode_trans_far = max_kode_number("fr_tc_far","kode_trans_far","");
	$tgl_trans=date("Y-m-d H:i:s");

	if($kode_profit==1000)
	{

		$kode_form_ri = max_kode_number("fr_tc_far","kode_form_ri","where status_transaksi=1 and kode_profit=".$kode_profit. " and month(tgl_trans)=".$bln." AND year(tgl_trans)=".$thn);
		$kode_form_rj = 0;
		$kode_form_rl = 0;
		$kode_form_bb = 0;
		$no_form = $kode_form_ri."/RI";

		$txt_nama_pasien = baca_tabel("mt_master_pasien","nama_pasien","WHERE no_mr='".$no_mr."'");
		$txt_telp = baca_tabel("mt_master_pasien","tlp_almt_ttp","WHERE no_mr='".$no_mr."'");
		$txt_alamat = baca_tabel("mt_master_pasien","almt_ttp_pasien","WHERE no_mr='".$no_mr."'");
		$txt_dokter_pengirim = baca_tabel("mt_karyawan","nama_pegawai","WHERE kode_dokter=".$kode_dokter);


	}elseif($kode_profit==2000)
	{
		$kode_form_ri = 0;
		//$kode_form_rj = max_kode_number("fr_tc_far","kode_form_rj","where status_transaksi=1 and kode_profit=".$kode_profit. " and  (day(tgl_trans) = ".$tgl." AND month(tgl_trans)=".$bln." AND year(tgl_trans)=".$thn.")");
		$kode_form_rj = max_kode_number("fr_tc_far","kode_form_rj","where status_transaksi=1 and kode_profit=".$kode_profit. " and month(tgl_trans)=".$bln." AND year(tgl_trans)=".$thn);
		$kode_form_rl = 0;
		$kode_form_bb = 0;
		$no_form = $kode_form_rj."/RJ";

		$txt_nama_pasien = baca_tabel("mt_master_pasien","nama_pasien","WHERE no_mr='".$no_mr."'");
		$txt_telp = baca_tabel("mt_master_pasien","tlp_almt_ttp","WHERE no_mr='".$no_mr."'");
		$txt_alamat = baca_tabel("mt_master_pasien","almt_ttp_pasien","WHERE no_mr='".$no_mr."'");
		$txt_dokter_pengirim = baca_tabel("mt_karyawan","nama_pegawai","WHERE kode_dokter=".$kode_dokter);


	}elseif($kode_profit==3000)
	{
		$kode_form_ri = 0;
		$kode_form_rj = 0;
		//$kode_form_rl = max_kode_number("fr_tc_far","kode_form_rl","where status_transaksi=1 and kode_profit=".$kode_profit. " and (day(tgl_trans) = ".$tgl." AND month(tgl_trans)=".$bln." AND year(tgl_trans)=".$thn.")");
		$kode_form_rl = max_kode_number("fr_tc_far","kode_form_rl","where status_transaksi=1 and kode_profit=".$kode_profit. " and  month(tgl_trans)=".$bln." AND year(tgl_trans)=".$thn);
		$kode_form_bb = 0;
		$no_form = $kode_form_rl."/RL";

	}elseif($kode_profit==4000)
	{
		$kode_form_ri = 0;
		$kode_form_rj = 0;
		$kode_form_rl = 0;
		//$kode_form_bb = max_kode_number("fr_tc_far","kode_form_bb","where status_transaksi=1 and kode_profit=".$kode_profit. " and (day(tgl_trans) = ".$tgl." AND month(tgl_trans)=".$bln." AND year(tgl_trans)=".$thn.")");
		$kode_form_bb = max_kode_number("fr_tc_far","kode_form_bb","where status_transaksi=1 and kode_profit=".$kode_profit. " and month(tgl_trans)=".$bln." AND year(tgl_trans)=".$thn);
		
		$no_form = $kode_form_bb."/Bebas";
	}

	//$kode_trans_far=max_kode_number("fr_tc_far","kode_trans_far","where status_transaksi=1 and kode_bagian='".$kode_bagian."'");
	//$kode_trans_far=max_kode_number("fr_tc_far","kode_trans_far","where kode_bagian='".$kode_bagian."'");
	$kode_trans_far=max_kode_number("fr_tc_far","kode_trans_far","");

	$result = true;

	$db->BeginTrans();

	//////////////////////////////////////////////////////////////////////

	unset($insertFrTcFar);

	$insertFrTcFar["kode_trans_far"] = $kode_trans_far;
	$insertFrTcFar["kode_pesan_resep"] = $kode_pesan_resep;
	$insertFrTcFar["kode_form_ri"] = $kode_form_ri;
	$insertFrTcFar["kode_form_rj"] = $kode_form_rj;
	$insertFrTcFar["kode_form_rl"] = $kode_form_rl;
	$insertFrTcFar["kode_form_bb"] = $kode_form_bb;
	$insertFrTcFar["no_resep"] = $no_form;
	$insertFrTcFar["tgl_trans"] = $tgl_trans;
	$insertFrTcFar["petugas"] = $petugas;
	$insertFrTcFar["no_mr"] = $no_mr;
	$insertFrTcFar["no_registrasi"] = $no_registrasi;
	$insertFrTcFar["no_kunjungan"] = $no_kunjungan;
	$insertFrTcFar["kode_dokter"] = $kode_dokter;
	$insertFrTcFar["nama_pasien"] = $txt_nama_pasien;
	$insertFrTcFar["alamat_pasien"] = $txt_alamat;
	$insertFrTcFar["telpon_pasien"] = $txt_telp;
	$insertFrTcFar["dokter_pengirim"] = $txt_dokter_pengirim;
	//$insertFrTcFar["status_transaksi"] = $status_transaksi;
	//$insertFrTcFar["status_tebus"] = $status_tebus;
	$insertFrTcFar["kode_bagian"] = $kode_bagian;
	$insertFrTcFar["kode_bagian_asal"] = $kode_bagian_asal;
	$insertFrTcFar["kode_profit"] = $kode_profit;
	$result = insert_tabel("fr_tc_far", $insertFrTcFar);

	//////////////////////////////////////////////////////////////////////

	$db->CommitTrans($result !== false);
	return $kode_trans_far;

}

// =================================== menyimpan detail transaksi ke tabel r_tc_far_detail ============================================//

function simpan_obat_far($kode_profit,$kode_pesan_resep,$kode_bagian,$kode_bagian_asal,$no_registrasi,$kode_dokter,$no_mr,$txt_kd_brg,$txt_jumlah,$txt_service,$kode_trans_far,$txt_tebus,$sisa="0",$no_kunjungan,$txt_jenis_obat,$kode_kelompok="",$kode_perusahaan="",$id_far="",$id_klas="")
{
	

	global $db;
	///////////////////variabel///////////////
	
	$kd_tr_resep=max_kode_number("fr_tc_far_detail","kd_tr_resep");

	$ada_brg=baca_tabel("fr_tc_far_detail","count(kode_brg)","where kode_brg='".$txt_kd_brg."' and kode_trans_far=".$kode_trans_far);
	//echo "<BR>ada_brg=".$ada_brg;
	if($ada_brg<1)
	{
		//////////////////////////////////////////////////////////////////////
		if($txt_jenis_obat==1)
		{
			$harga_beli=baca_tabel("fr_depo_cito","harga_beli","where kode_brg='".$txt_kd_brg."'");
			$harga_jual=baca_tabel("fr_depo_cito","harga_jual","where kode_brg='".$txt_kd_brg."'");

		
		}else
		{

			$arr_data=harga_far($kode_profit,$kode_bagian,$no_mr,$txt_kd_brg,$id_klas);
			$harga_beli=$arr_data["harga_beli"];
			$harga_jual=$arr_data["harga_jual"];
		}
		
		$ok=true;
		$db->BeginTrans();
		//$result = true;
		//$db->BeginTrans();

		//////////////////////////////////////////////////////////////////////

		unset($insertFrTcFarDetail);

		$_sqloPPN = "select * from fr_mt_profit_margin where kode_profit=".$kode_profit;
		$sqloPPN=&$db->Execute($_sqloPPN);
		$PPN=$sqloPPN->fields["ppn"];
		$harga_jual_sbl_ppn=$harga_jual;
		$harga_jual_ppn=$PPN/100*$harga_jual_sbl_ppn;
		$harga_jual=$harga_jual_sbl_ppn + $harga_jual_ppn;
		$txt_biaya_tebus=$harga_jual*$txt_tebus;
		$insertFrTcFarDetail["kd_tr_resep"] = $kd_tr_resep;
		$insertFrTcFarDetail["kode_trans_far"] = $kode_trans_far;
		$insertFrTcFarDetail["jumlah_pesan"] = $txt_jumlah;
		$insertFrTcFarDetail["jumlah_tebus"] = $txt_tebus;
		$insertFrTcFarDetail["biaya_tebus"] = $txt_biaya_tebus;
		$insertFrTcFarDetail["sisa"] = $sisa;
		$insertFrTcFarDetail["kode_brg"] = $txt_kd_brg;
		$insertFrTcFarDetail["harga_beli"] = $harga_beli;
		$insertFrTcFarDetail["harga_jual"] = $harga_jual;
		$insertFrTcFarDetail["harga_r"] = $txt_service;
		$insertFrTcFarDetail["id_tc_far_racikan"] = $id_far;
		$insertFrTcFarDetail["total_sbl_ppn"] = $harga_jual_sbl_ppn;
		$insertFrTcFarDetail["ppn"]				= $harga_jual_ppn;
		//$insertFrTcFarDetail["status_kirim"] = $status_kirim;

		if ($ok !== false)
			$ok = insert_tabel("fr_tc_far_detail", $insertFrTcFarDetail);
		
		//////////////////////////////////////////////////////////////////////
	}
	
	$db->CommitTrans($ok !== false);
	
	return $kd_tr_resep;

}

// =================================== mengecek pasien masih antrian di apotik atau ga ============================================//

	function cek_pesanan_far($no_mr,$kode_bagian_asal)
	{
		global $db;

		$_sqlo="SELECT count(kode_pesan_resep) as jum_pesan FROM fr_listpesanan_v WHERE ((status_tebus is null) or status_tebus=0) and kode_bagian_asal='".$kode_bagian_asal."' and kode_bagian like '060%' and no_mr='".$no_mr."' and lokasi_tebus=1";
		$sqlo=&$db->Execute($_sqlo);
		
		$jum_pesan_resep=$sqlo->fields["jum_pesan"];

		if($jum_pesan_resep>0)
		{
			$iHasil=1;
		}else
		{
			$iHasil=0;
		}
		
		return $iHasil;

	}
	
// =================================== menginput transaksi ke tabel fr_pengadaan_cito ============================================//
function pembelian_cito($txt_kd_brg,$txt_jumlah,$txt_harga_beli,$txt_harga_jual,$txt_tempat_beli,$induk_cito)
{
	global $db;

	$thn = date("Y");
	$bln = date("m");
	$tgl = date("d");

	$kode_trans_cito = max_kode_number("fr_pengadaan_cito","id_fr_pengadaan_cito");
	$tgl_trans=date("Y-m-d H:i:s");
	$kode_pengadaan="'".date("Ymd")."'";

	$total_harga=$txt_harga_beli*$txt_jumlah;

	if($kode_trans_cito==1)
	{
		$induk_cito=1;
	}
	
	$result = true;

	$db->BeginTrans();

	//////////////////////////////////////////////////////////////////////

	unset($insertFrPengadaanCito);

	$insertFrPengadaanCito["id_fr_pengadaan_cito"] = $kode_trans_cito;
	$insertFrPengadaanCito["kode_pengadaan"] = $kode_pengadaan;
	$insertFrPengadaanCito["tgl_pembelian"] = $tgl_trans;
	$insertFrPengadaanCito["kode_brg"] = $txt_kd_brg;
	$insertFrPengadaanCito["jumlah_kcl"] = $txt_jumlah;
	$insertFrPengadaanCito["harga_beli"] = $txt_harga_beli;
	$insertFrPengadaanCito["total_harga"] = $total_harga;
	$insertFrPengadaanCito["harga_jual"] = $txt_harga_jual;
	$insertFrPengadaanCito["flag_jurnal"] = 0;
	$insertFrPengadaanCito["induk_cito"] = $induk_cito;
	$insertFrPengadaanCito["tempat_pembelian"] = $txt_tempat_beli;
	$result = insert_tabel("fr_pengadaan_cito", $insertFrPengadaanCito);

	//////////////////////////////////////////////////////////////////////

	$db->CommitTrans($result !== false);

	return $induk_cito;


	
}

		/**
		 * tambah_depo_stok() : 
		 *
		 * @param  string  $kodeBrg  
		 * @param  string  $jumlah  
		 * @param  string  $kodeBagian  
		 *
		 */
		function tambah_depo_stokcito($kodeBrg,$jumlah,$harga_beli,$harga_jual) {
			if (is_numeric($jumlah)) {

				
				$jml_sat_kcl=baca_tabel("fr_depo_cito","jml_sat_kcl","WHERE kode_brg='".$kodeBrg."'");
				$jml_sat_kcl_sekarang = $jml_sat_kcl + $jumlah;
				$id_fr_depo_cito = max_kode_number("fr_depo_cito","id_fr_depo_cito");

				$ada_brg=baca_tabel("fr_depo_cito","kode_brg","WHERE kode_brg='".$kodeBrg."'");

				if($ada_brg<>"")
				{

					$fld=array();
					$fld["jml_sat_kcl"] = $jml_sat_kcl_sekarang;
					$fld["harga_beli"] = $harga_beli;
					$fld["harga_jual"] = $harga_jual;
					update_tabel("fr_depo_cito",$fld,"WHERE kode_brg='".$kodeBrg."'");

				}else
				{
					$fld=array();
					$fld["id_fr_depo_cito"] = $id_fr_depo_cito;
					$fld["kode_brg"] = $kodeBrg;
					$fld["jml_sat_kcl"] = $jumlah;
					$fld["harga_beli"] = $harga_beli;
					$fld["harga_jual"] = $harga_jual;
					insert_tabel("fr_depo_cito",$fld);

				}
			}
		} // end of public function tambah_depo_stok($kodeBrg,$jumlah,$kodeBagian)

		
		// ---------------------------------------------------------------------------------

		/**
		 * tambah_kartu_stok_cito() : 
		 *
		 * @param  string  $kodeBrg  
		 * @param  string  $jumlah  
		 * @param  string  $kodeBagian  
		 * @param  string  $jenisKartuStok  
		 * @param  string  $keterangan  
		 *
		 */
		function tambah_kartu_stokcito($kodeBrg,$jumlah,$kodeBagian,$jenisKartuStok,$keterangan="") {
			if (is_numeric($jumlah)) {
				$jml_sat_kcl=baca_tabel("fr_depo_cito","jml_sat_kcl","WHERE kode_brg='".$kodeBrg."'");
				$jml_sat_kcl_sekarang = $jml_sat_kcl + $jumlah;
				$id_kartu=max_kode_number("tc_kartu_stokcito","id_kartucito");
				$petugas=$loginInfo["no_induk"];
				$tgl_input = date("Y-m-d H:i:s");
				$ket=baca_tabel("mt_jenis_kartu_stok","nama_jenis","WHERE jenis_transaksi=".$jenisKartuStok)."; ";
				if ($keterangan!="") $ket.=" ".$keterangan;

				$fld=array();
				$fld["id_kartucito"] = $id_kartu;
				$fld["kode_brg"] = $kodeBrg;
				$fld["stok_awal"] = $jml_sat_kcl;
				$fld["pemasukan"] = $jumlah;
				$fld["pengeluaran"] = "0";
				$fld["stok_akhir"] = $jml_sat_kcl_sekarang;
				$fld["jenis_transaksi"] = $jenisKartuStok;
				$fld["kode_bagian"] = $kodeBagian;
				$fld["keterangan"] = $ket;
				$fld["petugas"] = $petugas;
				$fld["tgl_input"]= $tgl_input;
				insert_tabel("tc_kartu_stokcito",$fld);
			}
		} // end of function tambah_kartu_stokcito($kodeBrg,$jumlah,$kodeBagian)

		// ---------------------------------------------------------------------------------

		// ---------------------------------------------------------------------------------

		/**
		 * kurang_depo_stok_cito() : 
		 *
		 * @param  string  $kodeBrg  
		 * @param  string  $jumlah  
		 * @param  string  $kodeBagian  
		 *
		 */
		
		function kurang_depo_stokcito($kodeBrg,$jumlah) {
			if (is_numeric($jumlah)) {
				$jml_sat_kcl=baca_tabel("fr_depo_cito","jml_sat_kcl","WHERE kode_brg='".$kodeBrg."'");
				$jml_sat_kcl_sekarang = $jml_sat_kcl - $jumlah;

				$fld=array();
				$fld["jml_sat_kcl"] = $jml_sat_kcl_sekarang;
				update_tabel("fr_depo_cito",$fld,"WHERE kode_brg='".$kodeBrg."'");
			}
		} 
		// end of public function kurang_depo_stok($kodeBrg,$jumlah,$kodeBagian)

		function kurang_kartu_stokcito($kodeBrg,$jumlah,$kodeBagian,$jenisKartuStok,$keterangan="") {
			if (is_numeric($jumlah)) {
				$jml_sat_kcl=baca_tabel("fr_depo_cito","jml_sat_kcl","WHERE kode_brg='".$kodeBrg."'");
				$jml_sat_kcl_sekarang = $jml_sat_kcl - $jumlah;
				$id_kartucito=max_kode_number("tc_kartu_stokcito","id_kartucito");
				$petugas=$loginInfo["no_induk"];
				$tgl_input = date("Y-m-d H:i:s");
				$ket=baca_tabel("mt_jenis_kartu_stok","nama_jenis","WHERE jenis_transaksi=".$jenisKartuStok)."; ";
				if ($keterangan!="") $ket.=" ".$keterangan;

				$fld=array();
				$fld["id_kartucito"] = $id_kartucito;
				$fld["kode_brg"] = $kodeBrg;
				$fld["stok_awal"] = $jml_sat_kcl;
				$fld["pemasukan"] = "0";
				$fld["pengeluaran"] = $jumlah;
				$fld["stok_akhir"] = $jml_sat_kcl_sekarang;
				$fld["jenis_transaksi"] = $jenisKartuStok;
				$fld["kode_bagian"] = $kodeBagian;
				$fld["keterangan"] = $ket;
				$fld["petugas"] = $petugas;
				$fld["tgl_input"]= $tgl_input;
				insert_tabel("tc_kartu_stokcito",$fld);
			}
		} // end of public function kurang_kartu_stok($kodeBrg,$jumlah,$kodeBagian)

		function simpan_obat_far_kjs($kode_profit,$kode_pesan_resep,$kode_bagian,$kode_bagian_asal,$no_registrasi,$kode_dokter,$no_mr,$txt_kd_brg,$txt_jumlah,$txt_service,$kode_trans_far,$txt_tebus,$sisa="0",$no_kunjungan,$txt_jenis_obat,$kode_kelompok,$kode_perusahaan,$flag_kjs){

			global $db;
		///////////////////variabel///////////////
		
		$kd_tr_resep=max_kode_number("fr_tc_far_detail","kd_tr_resep");

		$ada_brg=baca_tabel("fr_tc_far_detail","count(kode_brg)","where kode_brg='".$txt_kd_brg."' and kode_trans_far=".$kode_trans_far);
		//echo "<BR>ada_brg=".$ada_brg;
		if($ada_brg<1)
		{
			//////////////////////////////////////////////////////////////////////
			if($txt_jenis_obat==1)
			{
				$harga_beli=baca_tabel("fr_depo_cito","harga_beli","where kode_brg='".$txt_kd_brg."'");
				$harga_jual=baca_tabel("fr_depo_cito","harga_jual","where kode_brg='".$txt_kd_brg."'");

			
			}else
			{

				$arr_data=harga_far_kjs($kode_profit,$kode_bagian,$no_mr,$txt_kd_brg,$kode_kelompok,$flag_kjs);
				$harga_beli=$arr_data["harga_beli"];
				$harga_jual=$arr_data["harga_jual"];
			}
			$txt_biaya_tebus=$harga_jual*$txt_tebus;
			$ok=true;
			$db->BeginTrans();
			//$result = true;
			//$db->BeginTrans();

			//////////////////////////////////////////////////////////////////////

			unset($insertFrTcFarDetail);

			$insertFrTcFarDetail["kd_tr_resep"] = $kd_tr_resep;
			$insertFrTcFarDetail["kode_trans_far"] = $kode_trans_far;
			$insertFrTcFarDetail["jumlah_pesan"] = $txt_jumlah;
			$insertFrTcFarDetail["jumlah_tebus"] = $txt_tebus;
			$insertFrTcFarDetail["biaya_tebus"] = $txt_biaya_tebus;
			$insertFrTcFarDetail["sisa"] = $sisa;
			$insertFrTcFarDetail["kode_brg"] = $txt_kd_brg;
			$insertFrTcFarDetail["harga_beli"] = $harga_beli;
			$insertFrTcFarDetail["harga_jual"] = $harga_jual;
			$insertFrTcFarDetail["harga_r"] = $txt_service;
			$insertFrTcFarDetail["flag_kjs"] = 10;

			if ($ok !== false)
				$ok = insert_tabel("fr_tc_far_detail", $insertFrTcFarDetail);


			}
		}
// =================================== menghitung harga_beli,harga_jual nasabah kjs============================================//

function harga_far_kjs($kode_profit,$kode_bagian,$no_mr,$txt_kd_brg,$kode_kelompok,$flag_kjs)
{
	global $db;

	$_sqlo = "select * from mt_depo_stok as a , mt_rekap_stok as b where a.kode_brg=b.kode_brg and a.kode_bagian='".$kode_bagian."' and a.kode_brg='".$txt_kd_brg."'";
	
	$sqlo=&$db->Execute($_sqlo);
	$harga_beli=$sqlo->fields["harga_beli"];

	$besar_profit=profit_margin_kjs($kode_profit,$txt_kd_brg,$kode_kelompok,$flag_kjs);
	$harga_jual=ceil($harga_beli * $besar_profit);
	
	$arrReturn["harga_beli"]=$harga_beli;
	$arrReturn["harga_jual"]=$harga_jual;
	$arrReturn["besar_profit"]=$besar_profit;
	return $arrReturn;


}
// =================================== menghitung profit margin nasabah KJS============================================//


function profit_margin_kjs($kode_profit,$txt_kd_brg,$kode_kelompok,$flag_kjs)
{
	global $db;
	///////////////////variabel///////////////
	$kategori=substr($txt_kd_brg,0,1);
	if($kategori=="D")
	{
		
		//Nantinya di hitung berdasarkan layanannya juga.
		
		$cek_nilai_profit=baca_tabel("fr_mt_profit_margin","profit_obat","WHERE kode_profit=10007");
		if($cek_nilai_profit!=''){
			$nilai_profit=$cek_nilai_profit;
		}else{

			$id_profit		=baca_tabel("mt_rekap_stok","id_profit","where  kode_brg='".$this->get("kode_barang")."'");
				if($id_profit!=""){
					$nilai_profit	=baca_tabel("fr_mt_profit_margin","profit_obat","WHERE id_profit=".$id_profit);
				}
		}
		/*Untuk rssm margin di hitung perobatnya belum ada standar  pakai ini*/

		

	}elseif($kategori=="E")
	{
		$cek_nilai_profit=baca_tabel("fr_mt_profit_margin","profit_alkes","WHERE kode_profit=10007");

		if($cek_nilai_profit!=''){
			$nilai_profit=$cek_nilai_profit;
		}else{

			$id_profit		=baca_tabel("mt_rekap_stok","id_profit","where  kode_brg='".$this->get("kode_barang")."'");
				if($id_profit!=""){
					$nilai_profit	=baca_tabel("fr_mt_profit_margin","profit_obat","WHERE id_profit=".$id_profit);
				}
		}

		/*Untuk rssm margin di hitung perobatnya belum ada standar  pakai ini*/

		

	}
	
	$kenaikan_profit=($nilai_profit*0.01)+1;
	return $kenaikan_profit;
}
?>
