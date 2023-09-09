<?
if(!class_exists("pajak_dr_xxx")){
	class pajak_dr_xxx{
		var $db;

		function InsertPajakDr($db,$bln_mulai,$thn_mulai,$kode_dokter,$jumlah_tagihan,$id_mt_pajak_progresif,$kena_pajak,$tampil_kumulatif,$persentase_pajak,$pph_21){
			$result = true;

			$db->BeginTrans();

			//////////////////////////////////////////////////////////////////////

			unset($insertTcPajakDokter);

			$insertTcPajakDokter["bulan_fee_dokter"] = $bln_mulai;
			$insertTcPajakDokter["thn_fee_dokter"] = $thn_mulai;
			$insertTcPajakDokter["kode_dokter"] = $kode_dokter;
			$insertTcPajakDokter["total_dr"] = $jumlah_tagihan;
			$insertTcPajakDokter["saldo_awal_dpp"] = $id_mt_pajak_progresif;	//sementara buat id_mt_pajak_progresif
			$insertTcPajakDokter["dpp"] = $kena_pajak;
			$insertTcPajakDokter["dpp_kumulatif"] = $tampil_kumulatif;
			$insertTcPajakDokter["lima_persen"] = $persentase_pajak;			//buat persentase_pajak
			$insertTcPajakDokter["status"] = $status;							//mbuh
			$insertTcPajakDokter["lima_belas_persen"] = $lima_belas_persen;		//mbuh
			$insertTcPajakDokter["dua_lima_persen"] = $dua_lima_persen;			//mbuh
			$insertTcPajakDokter["tiga_puluh_persen"] = $tiga_puluh_persen;		//mbuh
			$insertTcPajakDokter["pph_21"] = $pph_21;
			$result = insert_tabel("tc_pajak_dokter", $insertTcPajakDokter);

			//////////////////////////////////////////////////////////////////////

			$db->CommitTrans($result !== false);

		}

		function pajak_dr_xxx($db,$kode_dokter,$bln_mulai,$thn_mulai){
			$db->debug=true;

			$bill_non_nk_dr1 = 0;
			$bill_non_nk_dr2 = 0;
			$bill_non_nk_dr3 = 0;

			$bill_byr_nk_dr1 = 0;
			$bill_byr_nk_dr2 = 0;
			$bill_byr_nk_dr3 = 0;

			$bill_lns_nk_dr1 = 0;
			$bill_lns_nk_dr2 = 0;
			$bill_lns_nk_dr3 = 0;

			$param = "YEAR(tgl_transaksi)=".$thn_mulai." AND MONTH(tgl_transaksi)=".$bln_mulai." AND ";

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
			WHERE ".$param." status_selesai=3";

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

			$this->HasilHonorDr[$kode_dokter] = $tot_bill_non_nk+$tot_bill_byr_nk+$tot_bill_lns_nk;			
		}

		function NilaiHonorDr($kode_dokter){
			$hasil = $this->HasilHonorDr[$kode_dokter];
			return $hasil;
		}

		function NilaiPajakDr($db,$jumlah_tagihan,$kode_dokter,$bln_mulai,$thn_mulai){
			//$kumulatif = read_tabel("tc_pajak_dokter","dpp_kumulatif","WHERE kode_dokter=".$kode_dokter." AND bulan_fee_dokter=".$bln_mulai." AND thn_fee_dokter=".$thn_mulai);

			$sql = "SELECT * FROM mt_pajak_progresif ORDER BY nilai_max";
			$hasil =& $db->Execute($sql);
			$dpp = $jumlah_tagihan;
			$kumulatif = $kumulatif;

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
?>