<?
if(!class_exists("pajak_dr")){
	class pajak_dr{
		var $db;
		function pajak_dr($db,$kode_dokter,$bln_mulai,$thn_mulai){
			//$db->debug=true;			
			//////////////////////////////////////////////////////////////////////
			
			unset($editTcTransPelayanan);
			
			$editTcTransPelayanan["flag_pajak_dr"] = 9; //persiapan ke function InsertPajakDr
			//$result = update_tabel("tc_trans_pelayanan", $editTcTransPelayanan, "WHERE flag_pajak_dr=0 AND (kode_dokter1 > 0 OR kode_dokter2 > 0 OR kode_dokter3 > 0) AND (bill_dr1 > 0 OR bill_dr2 > 0 OR bill_dr3 > 0) AND status_selesai=3 AND ((MONTH(tgl_transaksi)=".$bln_mulai." AND YEAR(tgl_transaksi)=".$thn_mulai.") OR (MONTH(tgl_bayar_nk)=".$bln_mulai." AND YEAR(tgl_bayar_nk)=".$thn_mulai."))");
			$result = update_tabel("tc_trans_pelayanan", $editTcTransPelayanan, "WHERE flag_pajak_dr=0 AND (kode_dokter1 > 0 OR kode_dokter2 > 0 OR kode_dokter3 > 0) AND (bill_dr1 > 0 OR bill_dr2 > 0 OR bill_dr3 > 0) AND status_selesai=3 AND ((status_nk=1 AND MONTH(tgl_bayar_nk)=".$bln_mulai." AND YEAR(tgl_bayar_nk)=".$thn_mulai.") OR ((status_nk=0 OR status_nk IS NULL) AND MONTH(tgl_transaksi)=".$bln_mulai." AND YEAR(tgl_transaksi)=".$thn_mulai."))");

			//////////////////////////////////////////////////////////////////////
			//SMUA !
			/*
			$param = " AND (kode_dokter1=".$kode_dokter." OR kode_dokter2=".$kode_dokter." OR kode_dokter3=".$kode_dokter.") AND ((YEAR(tgl_transaksi)=".$thn_mulai." AND MONTH(tgl_transaksi)=".$bln_mulai.") OR (YEAR(tgl_bayar_nk)=".$thn_mulai." AND MONTH(tgl_bayar_nk)=".$bln_mulai.")";

			$q_dr = "SELECT 
			SUM(CASE WHEN bill_dr1>0 AND kode_dokter1=".$kode_dokter." THEN bill_dr1 ELSE 0 END) AS sum_bill_dr1,
			SUM(CASE WHEN bill_dr2>0 AND kode_dokter2=".$kode_dokter." THEN bill_dr2 ELSE 0 END) AS sum_bill_dr2,
			SUM(CASE WHEN bill_dr3>0 AND kode_dokter3=".$kode_dokter." THEN bill_dr3 ELSE 0 END) AS sum_bill_dr3
			FROM tc_trans_pelayanan 
			WHERE 1=1 ".$param." AND status_selesai=3 AND flag_pajak_dr=9";
			*/
			//////////////////////////////////////////////////////////////////////
			/*
			$q_dr = "SELECT 
			SUM(CASE WHEN bill_dr1>0 AND kode_dokter1=".$kode_dokter.$param_umum.$param_non_hd." THEN bill_dr1 ELSE 0 END) AS bill_umum_dr1,
			SUM(CASE WHEN bill_dr2>0 AND kode_dokter2=".$kode_dokter.$param_umum.$param_non_hd." THEN bill_dr2 ELSE 0 END) AS bill_umum_dr2,
			SUM(CASE WHEN bill_dr3>0 AND kode_dokter3=".$kode_dokter.$param_umum.$param_non_hd." THEN bill_dr3 ELSE 0 END) AS bill_umum_dr3,
			
			SUM(CASE WHEN bill_dr1>0 AND kode_dokter1=".$kode_dokter.$param_nk.$param_non_hd." THEN bill_dr1 ELSE 0 END) AS bill_nk_dr1,
			SUM(CASE WHEN bill_dr2>0 AND kode_dokter2=".$kode_dokter.$param_nk.$param_non_hd." THEN bill_dr2 ELSE 0 END) AS bill_nk_dr2,
			SUM(CASE WHEN bill_dr3>0 AND kode_dokter3=".$kode_dokter.$param_nk.$param_non_hd." THEN bill_dr3 ELSE 0 END) AS bill_nk_dr3,
			
			SUM(CASE WHEN bill_dr1>0 AND kode_dokter1=".$kode_dokter.$param_umum.$param_hd." THEN bill_dr1 + bill_dr2 ELSE 0 END) AS bill_umum_hd,
			SUM(CASE WHEN bill_dr1>0 AND kode_dokter1=".$kode_dokter.$param_nk.$param_hd." THEN bill_dr1 + bill_dr2 ELSE 0 END) AS bill_nk_hd

			FROM tc_trans_pelayanan 
			WHERE 1=1 ".$param." AND flag_pajak_dr=9 AND status_selesai=3";
			

			$bill_umum_dr1 = $res_dr->Fields('bill_umum_dr1');
			$bill_umum_dr2 = $res_dr->Fields('bill_umum_dr2');
			$bill_umum_dr3 = $res_dr->Fields('bill_umum_dr3');
			$bill_umum = $bill_umum_dr1+$bill_umum_dr2+$bill_umum_dr3;

			$bill_nk_dr1 = $res_dr->Fields('bill_nk_dr1');
			$bill_nk_dr2 = $res_dr->Fields('bill_nk_dr2');
			$bill_nk_dr3 = $res_dr->Fields('bill_nk_dr3');
			$bill_nk = $bill_nk_dr1+$bill_nk_dr2+$bill_nk_dr3;

			$bill_umum_hd = $res_dr->Fields('bill_umum_hd');
			$bill_nk_hd = $res_dr->Fields('bill_nk_hd');
			$bill_hd = $bill_umum_hd+$bill_nk_hd;
			*/
			//////////////////////////////////////////////////////////////////////

			$param			= "  AND (bill_dr1 > 0 OR bill_dr2 > 0 OR bill_dr3 > 0) AND (kode_dokter1=".$kode_dokter." OR kode_dokter2=".$kode_dokter." OR kode_dokter3=".$kode_dokter.")";
			$param_umum		= " AND (status_nk IS NULL OR status_nk=0) AND YEAR(tgl_transaksi)=".$thn_mulai." AND MONTH(tgl_transaksi)=".$bln_mulai;
			$param_nk		= " AND status_nk > 0 AND flag_bayar_nk=2 AND YEAR(tgl_bayar_nk)=".$thn_mulai." AND MONTH(tgl_bayar_nk)=".$bln_mulai;
			$param_hd		= " AND kode_bagian='013101'";
			$param_non_hd	= " AND kode_bagian<>'013101'";
			
			$q_dr = "SELECT 
			SUM(CASE WHEN kode_dokter3=".$kode_dokter.$param_umum.$param_non_hd." THEN bill_dr3 WHEN kode_dokter2=".$kode_dokter.$param_umum.$param_non_hd." THEN bill_dr2 WHEN kode_dokter1=".$kode_dokter.$param_umum.$param_non_hd." THEN bill_dr1 ELSE 0 END) AS bill_umum,
			
			SUM(CASE WHEN kode_dokter3=".$kode_dokter.$param_nk.$param_non_hd." THEN bill_dr3 WHEN kode_dokter2=".$kode_dokter.$param_nk.$param_non_hd." THEN bill_dr2 WHEN kode_dokter1=".$kode_dokter.$param_nk.$param_non_hd." THEN bill_dr1 ELSE 0 END) AS bill_nk,
			
			SUM(CASE WHEN kode_dokter1=".$kode_dokter.$param_umum.$param_hd." THEN bill_dr1 + bill_dr2 WHEN kode_dokter1=".$kode_dokter.$param_nk.$param_hd." THEN bill_dr1 + bill_dr2 ELSE 0 END) AS bill_hd

			FROM tc_trans_pelayanan 
			WHERE 1=1 ".$param." AND flag_pajak_dr=9 AND status_selesai=3";
			
			$res_dr =& $db->Execute($q_dr);	

			$bill_umum = $res_dr->Fields('bill_umum');
			$bill_nk = $res_dr->Fields('bill_nk');
			$bill_hd = $res_dr->Fields('bill_hd');

			$this->HasilHonorDr[$kode_dokter] = $bill_umum+$bill_nk+$bill_hd;			
			
		}

		function NilaiHonorDr($kode_dokter){
			$hasil = $this->HasilHonorDr[$kode_dokter];
			return $hasil;
		}

		function NilaiPajakDr($db,$jumlah_tagihan,$kode_dokter,$bln_mulai,$thn_mulai){
			//simulasi pajak progresif ada di _ujicoba/tes_pajak_dr.php
			//$db->debug=true;

			if($bln_mulai == 1){
				$kumulatif = 0;
			} else {
				$bln_kumulatif = $bln_mulai-1;
				$kumulatif = baca_tabel("tc_kartu_pajak_dr","dpp_kumulatif","WHERE kode_dr=".$kode_dokter." AND bln_pajak=".$bln_kumulatif." AND thn_pajak=".$thn_mulai." ORDER BY id_tc_kartu_pajak_dr DESC");
			}

			$honor_dr = $jumlah_tagihan;
			$dpp = $jumlah_tagihan * (50/100);

			$sql = "SELECT * FROM mt_pajak_progresif ORDER BY nilai_max";
			$hasil =& $db->Execute($sql);

			//dummy
			//$dpp = 26312000;
			//$kumulatif = 29180000;

			$i = 1;
		
			while ($tampil=$hasil->FetchRow()) {

				$id_mt_pajak_progresif = $tampil["id_mt_pajak_progresif"];
				$nilai_min = $tampil["nilai_min"];
				$nilai_max = $tampil["nilai_max"];
				$thn_pajak = $tampil["thn_pajak"];
				$persentase_pajak = $tampil["persentase_pajak"];
				
				$dpp_kumulatif = $kumulatif + $dpp;

				if($dpp_kumulatif >= $nilai_max){
					$id_check = 1;
					$tampil_kumulatif = $nilai_max;
					$kena_pajak = $nilai_max - $kumulatif;
				} else {
					$id_check = 2;
					$tampil_kumulatif = $dpp_kumulatif;
					$kena_pajak = ($i == 1)?$dpp : $dpp_kumulatif - $nilai_min;

				}
				if($kena_pajak >0 ):
					$i++;
					$pph_21 = $kena_pajak*($persentase_pajak/100);

					$tot_kena_pajak +=$pph_21;

					InsertPajakDr($db,$bln_mulai,$thn_mulai,$kode_dokter,$jumlah_tagihan,$id_mt_pajak_progresif,$kena_pajak,$tampil_kumulatif,$persentase_pajak,$pph_21);

				endif; //if($kena_pajak < 1):
			} // end of while ($hasil->FetchRow())



			$hasil = $this->HasilPajakDr[$kode_dokter];
			return $hasil;
		}
	}
}

function TambahinNol($nomornya,$max_panjang){
	$panjang_mr=strlen($nomornya);
	$sisa_panjang=$max_panjang-$panjang_mr;
	$tambah_nol="";
	for($i=1;$i<=$sisa_panjang;$i++)
		{
			$tambah_nol=$tambah_nol."0";
		}
	$hasilnya=$tambah_nol.$nomornya;

return $hasilnya;
}

function InsertPajakDr($db,$bln_mulai,$thn_mulai,$kode_dokter,$jumlah_tagihan,$id_mt_pajak_progresif,$kena_pajak,$tampil_kumulatif,$persentase_pajak,$pph_21){
	$result = true;
	//$db->debug=true;
	$db->BeginTrans();

	//////////////////////////////////////////////////////////////////////

	unset($insertTcKartuPajakDr);
	
	$total_pajak_dr +=$pph_21;
	$pendapatan_net_dr =$jumlah_tagihan - $total_pajak_dr;
	$insertTcKartuPajakDr["thn_pajak"] = $thn_mulai;
	$insertTcKartuPajakDr["bln_pajak"] = $bln_mulai;
	$insertTcKartuPajakDr["honor_dr"] = $jumlah_tagihan;
	$insertTcKartuPajakDr["net_dr"] = $jumlah_tagihan * (50/100);
	$insertTcKartuPajakDr["dpp"] = $kena_pajak;
	$insertTcKartuPajakDr["dpp_kumulatif"] = $tampil_kumulatif;
	$insertTcKartuPajakDr["persen_pajak"] = $persentase_pajak;
	$insertTcKartuPajakDr["pajak_dr"] = $pph_21;
	$insertTcKartuPajakDr["total_pajak_dr"] = $total_pajak_dr;
	$insertTcKartuPajakDr["pendapatan_net_dr"] = $pendapatan_net_dr;
	$insertTcKartuPajakDr["kode_dr"] = $kode_dokter;
	$insertTcKartuPajakDr["flag_status"] = 0;
	$insertTcKartuPajakDr["input_id"] = $loginInfo["id_dd_user"];
	$insertTcKartuPajakDr["input_tgl"] = date("Y-m-d H:i:s");
	$result = insert_tabel("tc_kartu_pajak_dr", $insertTcKartuPajakDr);
	$id_tc_kartu_pajak_dr = $db->Insert_ID();
	//////////////////////////////////////////////////////////////////////
	//$result = update_tabel("tc_trans_pelayanan", $editTcTransPelayanan, "WHERE flag_pajak_dr=9 AND (kode_dokter1=".$kode_dokter." OR kode_dokter2=".$kode_dokter." OR kode_dokter3=".$kode_dokter.") AND (bill_dr1 > 0 OR bill_dr2 > 0 OR bill_dr3 > 0) AND status_selesai=3 AND MONTH(tgl_transaksi)=".$bln_mulai." AND YEAR(tgl_transaksi)=".$thn_mulai);

	$sql_drx = "SELECT kode_trans_pelayanan, CASE 
	WHEN kode_dokter3=".$kode_dokter." THEN 'dr3' 
	WHEN kode_dokter2=".$kode_dokter." THEN 'dr2' 
	ELSE 'dr1' 
	END AS drx FROM tc_trans_pelayanan 
	WHERE 
	((MONTH(tgl_transaksi)=".$bln_mulai." AND YEAR(tgl_transaksi)=".$thn_mulai.") OR (MONTH(tgl_bayar_nk)=".$bln_mulai." AND YEAR(tgl_bayar_nk)=".$thn_mulai.")) 
	AND status_selesai=3 
	AND flag_pajak_dr=9 
	AND (kode_dokter1 = ".$kode_dokter." OR kode_dokter2 = ".$kode_dokter." OR kode_dokter3 = ".$kode_dokter.") 
	AND (bill_dr1 > 0 OR bill_dr2 > 0 OR bill_dr3 > 0)";
	$res_drx =& $db->Execute($sql_drx);	
	$hasil =& $db->Execute($sql);

	while ($fet_drx=$res_drx->FetchRow()) {

		$drx = $fet_drx["drx"];
		$kode_trans_pelayanan = $fet_drx["kode_trans_pelayanan"];

		unset($editTcTransPelayanan);

		switch($drx){
			case 'dr3':
				$editTcTransPelayanan["id_pajak_dr3"] = $id_tc_kartu_pajak_dr;
			break;
			case 'dr2':
				$editTcTransPelayanan["id_pajak_dr2"] = $id_tc_kartu_pajak_dr;
			break;
			default:
				$editTcTransPelayanan["id_pajak_dr1"] = $id_tc_kartu_pajak_dr;
		}
		
		$editTcTransPelayanan["flag_pajak_dr"] = 1;
		
		$result = update_tabel("tc_trans_pelayanan", $editTcTransPelayanan, "WHERE kode_trans_pelayanan=".$kode_trans_pelayanan);

	}
	//////////////////////////////////////////////////////////////////////

	$db->CommitTrans($result !== false);
	//$db->debug=false;
return $result;

}
?>