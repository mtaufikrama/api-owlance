<?
if(!class_exists("hitung_fee_dr")){
	class hitung_fee_dr{
		var $db;

		function hitung_fee_dr($db,$kode_dokter,$bln_mulai,$thn_mulai){
			
			$bill_non_nk_dr1 = 0;
			$bill_non_nk_dr2 = 0;
			$bill_non_nk_dr3 = 0;

			$bill_byr_nk_dr1 = 0;
			$bill_byr_nk_dr2 = 0;
			$bill_byr_nk_dr3 = 0;

			$bill_lns_nk_dr1 = 0;
			$bill_lns_nk_dr2 = 0;
			$bill_lns_nk_dr3 = 0;

			$q_dr = "SELECT 
			SUM(CASE WHEN bill_dr1>0 AND kode_kelompok<>3 AND (flag_kui_dr1 IS NULL OR flag_kui_dr1=0) AND kode_dokter1=".$kode_dokter." THEN bill_dr1 ELSE 0 END) AS bill_non_nk_dr1,
			SUM(CASE WHEN bill_dr2>0 AND kode_kelompok<>3 AND (flag_kui_dr2 IS NULL OR flag_kui_dr2=0) AND kode_dokter2=".$kode_dokter." THEN bill_dr2 ELSE 0 END) AS bill_non_nk_dr2,
			SUM(CASE WHEN bill_dr3>0 AND kode_kelompok<>3 AND (flag_kui_dr3 IS NULL OR flag_kui_dr3=0) AND kode_dokter3=".$kode_dokter." THEN bill_dr3 ELSE 0 END) AS bill_non_nk_dr3,

			SUM(CASE WHEN bill_dr1>0 AND kode_kelompok=3 AND (flag_kui_dr1 IS NULL OR flag_kui_dr1=0) AND (status_nk=0 OR status_nk IS NULL) AND kode_dokter1=".$kode_dokter." THEN bill_dr1 ELSE 0 END) AS bill_byr_nk_dr1,
			SUM(CASE WHEN bill_dr2>0 AND kode_kelompok=3 AND (flag_kui_dr2 IS NULL OR flag_kui_dr2=0) AND (status_nk=0 OR status_nk IS NULL) AND kode_dokter2=".$kode_dokter." THEN bill_dr2 ELSE 0 END) AS bill_byr_nk_dr2,
			SUM(CASE WHEN bill_dr3>0 AND kode_kelompok=3 AND (flag_kui_dr3 IS NULL OR flag_kui_dr3=0) AND (status_nk=0 OR status_nk IS NULL) AND kode_dokter3=".$kode_dokter." THEN bill_dr3 ELSE 0 END) AS bill_byr_nk_dr3,

			SUM(CASE WHEN bill_dr1>0 AND kode_kelompok=3 AND (flag_kui_dr1 IS NULL OR flag_kui_dr1=0) AND status_nk=1 AND flag_bayar_nk>0 AND kode_dokter1=".$kode_dokter." THEN bill_dr1 ELSE 0 END) AS bill_lns_nk_dr1,
			SUM(CASE WHEN bill_dr2>0 AND kode_kelompok=3 AND (flag_kui_dr2 IS NULL OR flag_kui_dr2=0) AND status_nk=1 AND flag_bayar_nk>0 AND kode_dokter2=".$kode_dokter." THEN bill_dr2 ELSE 0 END) AS bill_lns_nk_dr2,
			SUM(CASE WHEN bill_dr3>0 AND kode_kelompok=3 AND (flag_kui_dr3 IS NULL OR flag_kui_dr3=0) AND status_nk=1 AND flag_bayar_nk>0 AND kode_dokter3=".$kode_dokter." THEN bill_dr3 ELSE 0 END) AS bill_lns_nk_dr3
			FROM bd_tc_trans_flag_dr_v 
			WHERE month(tgl_transaksi)=".$bln_mulai." AND year(tgl_transaksi)=".$thn_mulai." AND status_selesai=3";

			$res_dr =& $db->Execute($q_dr);

			$bill_non_nk_dr1 = $res_dr->Fields('bill_non_nk_dr1');
			$bill_non_nk_dr2 = $res_dr->Fields('bill_non_nk_dr2');
			$bill_non_nk_dr3 = $res_dr->Fields('bill_non_nk_dr3');
			$tot_bill_non_nk = $bill_non_nk_dr1+$bill_non_nk_dr2+$bill_non_nk_dr3;

			$bill_byr_nk_dr1 = $res_dr->Fields('bill_byr_nk_dr1');
			$bill_byr_nk_dr2 = $res_dr->Fields('bill_byr_nk_dr2');
			$bill_byr_nk_dr3 = $res_dr->Fields('bill_byr_nk_dr3');
			$tot_bill_byr_nk = $bill_byr_nk_dr1+$bill_byr_nk_dr2+$bill_byr_nk_dr3;

			$bill_lns_nk_dr1 = $res_dr->Fields('bill_lns_nk_dr1');
			$bill_lns_nk_dr2 = $res_dr->Fields('bill_lns_nk_dr2');
			$bill_lns_nk_dr3 = $res_dr->Fields('bill_lns_nk_dr3');
			$tot_bill_lns_nk = $bill_lns_nk_dr1+$bill_lns_nk_dr2+$bill_lns_nk_dr3;

			$this->hasilDr[$kode_dokter] = $tot_bill_non_nk+$tot_bill_byr_nk+$tot_bill_lns_nk;			
		}

		function NilaifeeDr($kode_dokter){
			$hasil = $this->hasilDr[$kode_dokter];
			return $hasil;
		}	
	}
}
?>