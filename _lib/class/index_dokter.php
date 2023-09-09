<?
if(!class_exists("index_dokter")){
	class index_dokter{
		var $db;

		function index_dokter($db,$tgl_awal,$tgl_akhir){
			//$db->debug=true;
			// diambil dari trans pelayanan menggunakan time range dari kasir, tapi ga jadi.
			
			//$sql = "SELECT TOP 1000* FROM tc_trans_pelayanan WHERE tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' AND status_selesai=3 AND (kode_barang is null OR kode_barang='')";
			$sql = "SELECT SUM(bill_rs)AS bill_rs, SUM(bill_dr1)AS bill_dr1, SUM(bill_dr2)AS bill_dr2, SUM(bill_dr3) AS bill_dr3, SUM(jumlah) AS jumlah, RTRIM(LTRIM(kode_dokter1)) kode_dokter1,kode_dokter2,kode_dokter3,kode_bagian FROM tc_trans_pelayanan WHERE tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' AND status_selesai=3 AND (kode_barang IS NULL OR RTRIM(LTRIM(kode_barang))='') GROUP BY kode_dokter1,kode_dokter2,kode_dokter3,kode_bagian";
			
			//$sql ="select SUM(a.bill_rs)AS bill_rs, SUM(a.bill_dr1)AS bill_dr1, SUM(a.bill_dr2)AS bill_dr2, SUM(a.bill_dr3) AS bill_dr3, SUM(a.jumlah) AS jumlah, RTRIM(LTRIM(a.kode_dokter1)) kode_dokter1,a.kode_dokter2,a.kode_dokter3,a.kode_bagian from tc_trans_pelayanan a inner join tc_trans_kasir b on a.kode_tc_trans_kasir=b.kode_tc_trans_kasir WHERE b.tgl_jam between '$tgl_awal' AND '$tgl_akhir' AND a.status_selesai=3 AND (a.kode_barang IS NULL OR RTRIM(LTRIM(a.kode_barang))='') GROUP BY a.kode_dokter1,a.kode_dokter2,a.kode_dokter3,a.kode_bagian";
			$hasil = $db->Execute($sql);
			
			while ($tampil=$hasil->FetchRow()) {
				$bill_rs = $tampil["bill_rs"];
				$bill_dr1 = $tampil["bill_dr1"];
				$bill_dr2 = $tampil["bill_dr2"];
				$bill_dr3 = $tampil["bill_dr3"];
				$kode_dokter1 = $tampil["kode_dokter1"];
				$kode_dokter2 = $tampil["kode_dokter2"];
				$kode_dokter3 = $tampil["kode_dokter3"];
				$kode_bagian = $tampil["kode_bagian"];
				$jumlah = $tampil["jumlah"];
				
				$this->hasilDokter1[$kode_dokter1][$kode_bagian]	+= $bill_dr1;
				$this->hasilDokter2[$kode_dokter2][$kode_bagian]	+= $bill_dr2;
				$this->hasilDokter3[$kode_dokter3][$kode_bagian]	+= $bill_dr3;
				$this->hasilRs[trim($kode_dokter1)][$kode_bagian]	+= $bill_rs;
				//$this->
			}
			/*
			echo "<pre>";
			print_r($this->hasilRs);
			echo "</pre>";
			*/
			$sql_1 = "SELECT sum(bill_rs) as bill_rs,sum(jumlah) as jumlah,kode_bagian,kode_dokter1 FROM tc_trans_pelayanan WHERE tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' AND status_selesai=3 AND (kode_barang is not null OR kode_barang!='') GROUP BY kode_bagian,kode_dokter1";

			//$sql_1 = "SELECT sum(a.bill_rs) as bill_rs,sum(a.jumlah) as jumlah,a.kode_bagian,a.kode_dokter1 FROM tc_trans_pelayanan a inner join tc_trans_kasir b on a.kode_tc_trans_kasir=b.kode_tc_trans_kasir WHERE tgl_jam between '$tgl_awal' AND '$tgl_akhir' AND a.status_selesai=3 AND (a.kode_barang is not null OR a.kode_barang!='') GROUP BY a.kode_bagian,a.kode_dokter1";
			$hasil_1 = $db->Execute($sql_1);

			while ($tampil_1=$hasil_1->FetchRow()) {
				$bill_rs_1		= $tampil_1["bill_rs"];
				$jumlah_1		= $tampil_1["jumlah"];
				$kode_bagian_1	= $tampil_1["kode_bagian"];
				$kode_dokter1_1	= $tampil_1["kode_dokter1"];
				$this->hasilObat[$kode_bagian_1]							+= $bill_rs_1;
				$this->hasilFarmasi[$kode_dokter1_1][$kode_bagian_1]		+= $bill_rs_1;	
			}
			/*
			echo "<pre>";
			print_r($this->hasilObat);
			echo "</pre>";
			*/
			
			$sql_2 = "select count(no_mr)as jml_pasien,kode_dokter1 from tc_trans_pelayanan WHERE tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' AND status_selesai=3 group by kode_dokter1";

			$hasil_2 = $db->Execute($sql_2);
			while ($tampil_2=$hasil_2->FetchRow()) {
				$kode_dokter1_2	= $tampil_2["kode_dokter1"];
				$jml_pasien		= $tampil_2["jml_pasien"];

				$this->hasilPasien[$kode_dokter1_2] = $jml_pasien;
			}
			/*
			echo "<pre>";
			print_r($this->hasilPasien);
			echo "</pre>";
			*/
			$sql_3 = "select a.jumlah_transaksi,a.no_registrasi,b.kode_bagian_masuk kode_bagian,c.bill_rs,(a.jumlah_transaksi*c.bill_rs) biaya_kartu from tc_trans_kartu a inner join tc_registrasi b on a.no_registrasi=b.no_registrasi, mt_master_tarif_kartu c where a.flag_bayar=1 AND tgl_transaksi between '$tgl_awal' AND '$tgl_akhir'";

			$hasil_3 = $db->Execute($sql_3);
			while ($tampil_3=$hasil_3->FetchRow()){
				$kode_bagian_3	= $tampil_3["kode_bagian"];
				$biaya_kartu	= $tampil_3["biaya_kartu"];

				$this->biayaKartu[$kode_bagian_3]	+= $biaya_kartu;
			}
			/*
			echo "<pre>";
			print_r($this->biayaKartu);
			echo "</pre>";
			*/
		}
		function totalPasien($kode_dokter){
			$hasil = $this->hasilPasien[$kode_dokter];
			return $hasil;
		}

		function totalDokter($kode_dokter_t,$kode_bagian_t){
			$hasil1 = $this->hasilDokter1[$kode_dokter_t][$kode_bagian_t];
			$hasil2 = $this->hasilDokter2[$kode_dokter_t][$kode_bagian_t];
			$hasil3 = $this->hasilDokter3[$kode_dokter_t][$kode_bagian_t];
			
			$hasil = (int)$hasil1 + (int)$hasil2 + (int)$hasil3;
			
			return $hasil;
		}
		
		function totalFarmasi($kode_dokter_x,$kode_bagian_x){
			$hasil = $this->hasilFarmasi[$kode_dokter_x][$kode_bagian_x];
			return $hasil;
		}
		
		function totalRs($kode_dokter,$kode_bagian){
			$hasil = $this->hasilRs[$kode_dokter][$kode_bagian];
			return $hasil;
		}

		function totalObat($kode_bagian){
			$hasil = $this->hasilObat[$kode_bagian];
			return $hasil;
		}

		function totalNonDr($kode_bagian){
			$hasil = $this->hasilRs[$isiKosong][$kode_bagian];
			return $hasil;
		}

		function totalKartu($kode_bagian){
			$hasil = $this->biayaKartu[$kode_bagian];
			return $hasil;
		}
	}
}
?>