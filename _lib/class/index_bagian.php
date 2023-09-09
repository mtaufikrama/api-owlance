<?
if(!class_exists("index_bagian")){
	class index_bagian{
		var $db;

		function index_bagian($db,$frekuensi,$txt_thn,$txt_bln,$txt_tgl){
			switch ($frekuensi){
				case "1":
					$sqlT = " AND DAY(tgl_transaksi)=$txt_tgl AND MONTH(tgl_transaksi)=$txt_bln AND YEAR(tgl_transaksi)=$txt_thn";
					break;
				case "2":
					$sqlT = " AND MONTH(tgl_transaksi)=$txt_bln AND YEAR(tgl_transaksi)=$txt_thn";
					break;
				case "3":
					$sqlT = " AND YEAR(tgl_transaksi)=$txt_thn";
					break;
			}
			//$db->debug=true;
			$sql = "SELECT SUM(bill_rs) bill_rs, SUM(bill_dr1) bill_dr1,SUM(bill_dr2) bill_dr2, SUM(bill_dr3) bill_dr3, kode_bagian FROM tc_trans_pelayanan WHERE kode_bagian IS NOT NULL AND (kode_barang IS NULL OR RTRIM(LTRIM(kode_barang))='') AND status_selesai=3 $sqlT GROUP BY kode_bagian ";
			$hasil = $db->Execute($sql);
			
			while ($tampil=$hasil->FetchRow()) {
				$bill_rs		= $tampil["bill_rs"];
				$bill_dr1		= $tampil["bill_dr1"];
				$bill_dr2		= $tampil["bill_dr2"];
				$bill_dr3		= $tampil["bill_dr3"];
				$kode_bagian	= $tampil["kode_bagian"];
				
				$this->hasilDokter1[$kode_bagian]	+= $bill_dr1;
				$this->hasilDokter2[$kode_bagian]	+= $bill_dr2;
				$this->hasilDokter3[$kode_bagian]	+= $bill_dr3;
				$this->hasilRs[$kode_bagian]		+= $bill_rs;
				//$this->
				
				
			}
			/*
			echo "<pre>";
			print_r($this->hasilDokter1);
			echo "</pre>";
			*/
			$sql_1 = "SELECT SUM(bill_rs) bill_rs, SUM(bill_dr1) bill_dr1,SUM(bill_dr2) bill_dr2, SUM(bill_dr3) bill_dr3, kode_bagian FROM tc_trans_pelayanan WHERE kode_bagian IS NOT NULL AND (kode_barang IS NOT NULL AND RTRIM(LTRIM(kode_barang))!='') AND status_selesai=3 $sqlT  GROUP BY kode_bagian ";
			$hasil_1 = $db->Execute($sql_1);

			while ($tampil_1=$hasil_1->FetchRow()) {
				$bill_rs_1		= $tampil_1["bill_rs"];
				$kode_bagian_1	= $tampil_1["kode_bagian"];
				$this->hasilObat[$kode_bagian_1]	+= $bill_rs_1;
			}
			/*
			echo "<pre>";
			print_r($this->hasilObat);
			echo "</pre>";
			*/
	
		}
		function totalRs($kode_bagian){
			$hasil = $this->hasilRs[$kode_bagian];
			return $hasil;
		}
		function totalDr1($kode_bagian){
			$hasil = $this->hasilDokter1[$kode_bagian];
			return $hasil;
		}
		function totalDr2($kode_bagian){
			$hasil = $this->hasilDokter2[$kode_bagian];
			return $hasil;
		}
		function totalDr3($kode_bagian){
			$hasil = $this->hasilDokter3[$kode_bagian];
			return $hasil;
		}
		function totalObat($kode_bagian){
			$hasil = $this->hasilObat[$kode_bagian];
			return $hasil;
		}
	}
}
?>