<?
if(!class_exists("index_dokter")){
	class index_dokter{
		var $db;

		function index_dokter($db,$tgl_awal,$tgl_akhir){
			//$db->debug=true;
			/* $sql = "select sum(bill_rs)as bill_rs, sum(bill_dr1)as bill_dr1, sum(bill_dr2)as bill_dr2, sum(bill_dr3) as bill_dr3, sum(jumlah) as jumlah, kode_dokter1,kode_dokter2,kode_dokter3,kode_bagian from tc_trans_pelayanan tgl_transaksi WHERE tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' AND status_selesai=3 AND (kode_barang is null OR kode_barang='') GROUP BY kode_dokter1,kode_dokter2,kode_dokter3,kode_bagian";
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
				$this->hasilRs[$kode_dokter1][$kode_bagian]			+= $bill_rs;
			} */
			$sql ="SELECT SUM(jasa_dokter) as bill_rs,kode_bagian,kode_dokter,COUNT(no_mr) AS pasien FROM tc_jasa_medis WHERE kode_trans_pelayanan IN (SELECT kode_trans_pelayanan FROM tc_trans_pelayanan WHERE status_selesai=3 AND tgl_transaksi between '$tgl_awal' AND '$tgl_akhir') AND no_mr IN (SELECT no_mr FROM tc_trans_kasir) GROUP BY kode_dokter,kode_bagian";
			$hasil = $db->Execute($sql);			
			while ($tampil=$hasil->FetchRow()) {
				$bill_rs = $tampil["bill_rs"];
				$kode_dokter1 = $tampil["kode_dokter"];
				$kode_bagian = $tampil["kode_bagian"];
				$this->hasilRs[$kode_dokter1][$kode_bagian]			+= $bill_rs;
			}
			/*
			echo "<pre>";
			print_r($this->hasilDokter1);
			echo "</pre>";
			*/
			/*$sql_1 = "SELECT sum(bill_rs) as bill_rs,sum(jumlah) as jumlah,kode_bagian,kode_dokter1 FROM tc_trans_pelayanan WHERE tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' AND status_selesai=3 AND (kode_barang is not null OR kode_barang!='') GROUP BY kode_bagian,kode_dokter1";
			$hasil_1 = $db->Execute($sql_1);

			while ($tampil_1=$hasil_1->FetchRow()) {
				$bill_rs_1		= $tampil_1["bill_rs"];
				$jumlah_1		= $tampil_1["jumlah"];
				$kode_bagian_1	= $tampil_1["kode_bagian"];
				$kode_dokter1_1	= $tampil_1["kode_dokter1"];
				$this->hasilObat[$kode_bagian_1]							+= $bill_rs_1;
				$this->hasilFarmasi[$kode_dokter1_1][$kode_bagian_1]		+= $bill_rs_1;	
			} */
			$sql_1 ="SELECT SUM(jasa_dokter) as bill_rs,kode_bagian,kode_dokter,COUNT(no_mr) AS pasien FROM tc_jasa_medis WHERE kode_trans_pelayanan IN (SELECT kode_trans_pelayanan FROM tc_trans_pelayanan WHERE status_selesai=3 AND tgl_transaksi between '$tgl_awal' AND '$tgl_akhir') AND no_mr IN (SELECT no_mr FROM tc_trans_kasir) GROUP BY kode_dokter,kode_bagian";
			$hasil_1 = $db->Execute($sql_1);
			while ($tampil_1=$hasil_1->FetchRow()) {
				$bill_rs_1		= $tampil_1["bill_rs"];
				//$jumlah_1		= $tampil_1["jumlah"];
				$kode_bagian_1	= $tampil_1["kode_bagian"];
				$kode_dokter1_1	= $tampil_1["kode_dokter"];
				$this->hasilObat[$kode_bagian_1]							+= $bill_rs_1;
				$this->hasilFarmasi[$kode_dokter1_1][$kode_bagian_1]		+= $bill_rs_1;	
			}
			/*
			echo "<pre>";
			print_r($this->hasilObat);
			echo "</pre>";
			*/
			
			/* v1 5/6/2008 9:50:25 AM
			$sql_2 = "select count(no_mr)as jml_pasien,kode_dokter1 from tc_trans_pelayanan WHERE tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' AND status_selesai=3 group by kode_dokter1";

			$hasil_2 = $db->Execute($sql_2);
			while ($tampil_2=$hasil_2->FetchRow()) {
				$kode_dokter1_2	= $tampil_2["kode_dokter1"];
				$jml_pasien		= $tampil_2["jml_pasien"];

				$this->hasilPasien[$kode_dokter1_2] = $jml_pasien;
			}
			
			echo "<pre>";
			print_r($this->hasilPasien);
			echo "</pre>";
			
			}
			function totalPasien($kode_dokter){
				$hasil = $this->hasilPasien[$kode_dokter];
				return $hasil;
			}
			$sql_2 = "select count(no_mr)as jml_pasien1,kode_dokter1,count(no_mr)as jml_pasien2,kode_dokter2,count(no_mr)as jml_pasien3,kode_dokter3 from tc_trans_pelayanan WHERE tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' AND status_selesai=3 group by kode_dokter1,kode_dokter2,kode_dokter3";
			$hasil_2 = $db->Execute($sql_2);
			while ($tampil_2=$hasil_2->FetchRow()) {
				$kode_dokter1_2	= $tampil_2["kode_dokter1"];
				$jml_pasien1_2	= $tampil_2["jml_pasien1"];
				$kode_dokter2_2	= $tampil_2["kode_dokter2"];
				$jml_pasien2_2	= $tampil_2["jml_pasien2"];
				$kode_dokter3_2	= $tampil_2["kode_dokter3"];
				$jml_pasien3_2	= $tampil_2["jml_pasien3"];

				$this->hasilPasien1[$kode_dokter1_2] = $jml_pasien1_2;
				$this->hasilPasien2[$kode_dokter2_2] = $jml_pasien2_2;
				$this->hasilPasien3[$kode_dokter3_2] = $jml_pasien3_2;
			}
			*/
			
			$sql_2 ="SELECT COUNT(no_mr) as jml_pasien1,kode_dokter FROM tc_jasa_medis WHERE kode_trans_pelayanan IN (SELECT kode_trans_pelayanan FROM tc_trans_pelayanan WHERE status_selesai=3 AND tgl_transaksi between '$tgl_awal' AND '$tgl_akhir') GROUP BY kode_dokter";

			$hasil_2 = $db->Execute($sql_2);
			while ($tampil_2=$hasil_2->FetchRow()) {
				$kode_dokter1_2	= $tampil_2["kode_dokter"];
				$jml_pasien1_2	= $tampil_2["jml_pasien1"];
				$this->hasilPasien1[$kode_dokter1_2] = $jml_pasien1_2;
			}

			/*$sql_3 = "select kode_dokter1,sum(bill_dr1)as bill_dr1,kode_dokter2,sum(bill_dr2)as bill_dr2,kode_dokter3,sum(bill_dr3)as bill_dr3 from tc_trans_pelayanan where status_selesai>=2 AND (tgl_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir') group by kode_dokter1,kode_dokter2,kode_dokter3";

			$hasil_3 = $db->Execute($sql_3);
			while ($tampil_3=$hasil_3->Fetchrow()){
				$kode_dokter3_1		= $tampil_3["kode_dokter1"];
				$bill_dr3_1			= $tampil_3["bill_dr1"];
				$kode_dokter3_2		= $tampil_3["kode_dokter2"];
				$bill_dr3_2			= $tampil_3["bill_dr2"];
				$kode_dokter3_3		= $tampil_3["kode_dokter3"];
				$bill_dr3_3			= $tampil_3["bill_dr3"];

				if((trim($kode_dokter3_1)!="") AND (trim($bill_dr3_1)>0))
				$this->totBillDr[$kode_dokter3_1] += $bill_dr3_1;
				if((trim($kode_dokter3_2)!="") AND (trim($bill_dr3_2)>0))
				$this->totBillDr[$kode_dokter3_2] += $bill_dr3_2;
				if((trim($kode_dokter3_3)!="") AND (trim($bill_dr3_3)>0))
				$this->totBillDr[$kode_dokter3_3] += $bill_dr3_3;			
			} */
			$sql_3 ="SELECT SUM(jasa_dokter) as bill_dr1,kode_dokter FROM tc_jasa_medis WHERE kode_trans_pelayanan IN (SELECT kode_trans_pelayanan FROM tc_trans_pelayanan WHERE status_selesai=2 AND tgl_transaksi between '$tgl_awal' AND '$tgl_akhir') GROUP BY kode_dokter";

			$hasil_3 = $db->Execute($sql_3);
			while ($tampil_3=$hasil_3->Fetchrow()){
				$kode_dokter3_1		= $tampil_3["kode_dokter"];
				$bill_dr3_1			= $tampil_3["bill_dr1"];

				if((trim($kode_dokter3_1)!="") AND (trim($bill_dr3_1)>0))
				$this->totBillDr[$kode_dokter3_1] += $bill_dr3_1;
			}
		}
		function totalPasien($kode_dokter){
			$hasil = $this->hasilPasien1[$kode_dokter];
			$hasi2 = $this->hasilPasien2[$kode_dokter];
			$hasi3 = $this->hasilPasien3[$kode_dokter];

			$hasil = (int)$hasil + (int)$hasi2 + (int)$hasi3;

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
	}
}
?>