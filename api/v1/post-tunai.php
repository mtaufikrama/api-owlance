<?php
include "cek-token.php";

// no_registrasi, pembayar, tagihan, tunai

$no_mr		= baca_tabel('tc_registrasi', 'no_mr', "where no_registrasi=$no_registrasi");
$no_induk   = baca_tabel('mt_karyawan','no_induk',"where no_mr='$no_mr'");
$id_dd_user = baca_tabel('dd_user', 'id_dd_user',"where no_induk=$no_induk");
$namaPasien = baca_tabel('mt_master_pasien','nama_pasien',"where no_mr='$no_mr'");
$kode_bagian= baca_tabel('tc_registrasi','kode_bagian_masuk',"where no_mr='$no_mr'");

	// if(!is_numeric($shift_manual)) die("pilih shift dahulu!");

	// if($shift!=$shift_manual){
	// 	$shift=$shift_manual;
	// }else{
	// 	$shift=$shift;
	// }

    unset($insertTcTransKasir);
		
    $biayaKartu=biaya_kartu($no_registrasi);

    $kode_tc_trans_kasir = max_kode_number("tc_trans_kasir", "kode_tc_trans_kasir");
    //if($no_registrasi>0)$kode_perusahaan = baca_tabel("tc_registrasi", "kode_perusahaan", "where no_registrasi=".$no_registrasi);
    $kode_perusahaan = baca_tabel("mt_master_pasien", "kode_perusahaan", "where no_mr='".$no_mr."'");
    
    //if(submit_uang($jumlahNKP) > 0 && $no_mr!="0" && ($kode_perusahaan=="" || $kode_perusahaan==" " || $kode_perusahaan=="0") ){
        //$kode_perusahaan = baca_tabel("mt_master_pasien", "kode_perusahaan", "where no_mr='".$no_mr."'");
        //echo "cc:".$kode_perusahaan;
    //}
    //echo "aa:".$kode_perusahaan;
    $insertTcTransKasir["kode_tc_trans_kasir"] = $kode_tc_trans_kasir;

    $seri_kuitansi = AV_KASIR_KODE_KUITANSI_RJ;	

    if (((int)$kode_bagian > 30000) && ((int)$kode_bagian < 40000))
        // RI
        $seri_kuitansi = AV_KASIR_KODE_KUITANSI_RI;	
    
    $no_kuitansi = (int)baca_tabel("tc_trans_kasir", "MAX(no_kuitansi)", "WHERE seri_kuitansi = '$seri_kuitansi'") + 1;

    $insertTcTransKasir["seri_kuitansi"] = $seri_kuitansi;
    $insertTcTransKasir["no_kuitansi"] = $no_kuitansi;
    $insertTcTransKasir["no_induk"] = $no_induk; 
    $insertTcTransKasir["tgl_jam"] = date("Y-m-d H:i:s");
    $insertTcTransKasir["bill"] = $tagihan;
    $insertTcTransKasir["plafon"] = submit_uang($plafon);

    // ??????????????
    //$insertTcTransKasir["tambahan"] = $tambahan;

    if (!isset($jumlahDiskonP)) $jumlahDiskonP = 0;
    if (!isset($nilaiDiskonnya)) $nilaiDiskonnya = 0;
    if (!isset($tunai)) $tunai = 0;
    if (!isset($jumlahDebet)) $jumlahDebet = 0;

    /*Multiple Debet----------------------------*/
    if (!isset($jumlahDebet1)) $jumlahDebet1 = 0;
    if (!isset($jumlahDebet2)) $jumlahDebet2 = 0;
    if (!isset($jumlahDebet3)) $jumlahDebet3 = 0;
    if (!isset($jumlahDebet4)) $jumlahDebet4 = 0;
    /*-----------------------------------------*/
    if (!isset($jumlahKredit)) $jumlahKredit = 0;
    /*Multiple kredit----------------------------*/
    if (!isset($jumlahKredit1)) $jumlahKredit1 = 0;
    if (!isset($jumlahKredit2)) $jumlahKredit2 = 0;
    if (!isset($jumlahKredit3)) $jumlahKredit3 = 0;
    if (!isset($jumlahKredit4)) $jumlahKredit4 = 0;
    /*-----------------------------------------*/

    if (!isset($nk)) $nk = 0;
    if (!isset($cetakKartu)) $cetakKartu = 0;
    if (!isset($nd)) $nd = 0;
    if (!isset($jumlahNK)) $jumlahNK = 0;
    if (!isset($jumlahNKP)) $jumlahNKP = 0;
    if (!isset($jumlahAskes)) $jumlahAskes = 0;
    if (!isset($jumlahNPendiri)) $jumlahNPendiri = 0;
    if (!isset($pembulatan)) $pembulatan = 0;

    $pembulatan=submit_uang($pembulatan);

    $jumlahDiskonP = submit_uang($jumlahDiskonP);
    if($nilaiDiskonnya > 0 ){
        $jumlahDiskonP = $nilaiDiskonnya;
    }
    $tunai = submit_uang($tunai);
    $jumlahDebet = submit_uang($jumlahDebet);
    /*Multiple Debet----------------------------*/
    $jumlahDebet1 = submit_uang($jumlahDebet1);
    $jumlahDebet2 = submit_uang($jumlahDebet2);
    $jumlahDebet3 = submit_uang($jumlahDebet3);
    $jumlahDebet4 = submit_uang($jumlahDebet4);
    /*-------------------------------------------*/
    $jumlahKredit = submit_uang($jumlahKredit);
    /*Multiple kredit----------------------------*/
    $jumlahKredit1 = submit_uang($jumlahKredit1);
    $jumlahKredit2 = submit_uang($jumlahKredit2);
    $jumlahKredit3 = submit_uang($jumlahKredit3);
    $jumlahKredit4 = submit_uang($jumlahKredit4);
    /*-------------------------------------------*/
    //$nk = submit_uang($nk);
    if ($biayaKartu>0){
        $cetakKartu = $biayaKartu;
    }
    $nd = submit_uang($nilaiND);
    $jumlahNK = submit_uang($jumlahNK);
    $jumlahNKP = submit_uang($jumlahNKP);
    //$jumlahAskes = submit_uang($jumlahAskes);
    //$pembulatan = submit_uang($pembulatan);

    
    $insertTcTransKasir["potongan"] = $nilaiDiskonnya;
    
    if($tunai<0){
        $nd=$tunai*-1;
        $tunai=0;
    }else{
        $tunai=$tunai;
    }

    $insertTcTransKasir["tunai"] = $tunai;
    $insertTcTransKasir["debet"] = $jumlahDebet;

    /*multiple debet-------------------------------*/
    $insertTcTransKasir["debet1"] = $jumlahDebet1;
    $insertTcTransKasir["debet2"] = $jumlahDebet2;
    $insertTcTransKasir["debet3"] = $jumlahDebet3;
    $insertTcTransKasir["debet4"] = $jumlahDebet4;
    /*---------------------------------------------*/

    $insertTcTransKasir["no_debet"] = $noKartuDebet;
    
    /*multiple debet-------------------------------*/
    $insertTcTransKasir["no_debet1"] = $noKartuDebet1;
    $insertTcTransKasir["no_debet2"] = $noKartuDebet2;
    $insertTcTransKasir["no_debet3"] = $noKartuDebet3;
    $insertTcTransKasir["no_debet4"] = $noKartuDebet4;
    /*---------------------------------------------*/

    $insertTcTransKasir["kredit"] = $jumlahKredit;
    
    /*multiple kredit-------------------------------*/
    $insertTcTransKasir["kredit1"] = $jumlahKredit1;
    $insertTcTransKasir["kredit2"] = $jumlahKredit2;
    $insertTcTransKasir["kredit3"] = $jumlahKredit3;
    $insertTcTransKasir["kredit4"] = $jumlahKredit4;
    /*---------------------------------------------*/

    $insertTcTransKasir["no_kredit"] = $noKartuKredit;

    /*multiple kredit-------------------------------*/
    $insertTcTransKasir["no_kredit1"] = $noKartuKredit1;
    $insertTcTransKasir["no_kredit2"] = $noKartuKredit2;
    $insertTcTransKasir["no_kredit3"] = $noKartuKredit3;
    $insertTcTransKasir["no_kredit4"] = $noKartuKredit4;
    $insertTcTransKasir["id_dd_user"] = $id_dd_user;
    /*---------------------------------------------*/

    //$insertTcTransKasir["nk"] = $nk;
    /**************************************************************/
    
    //ADDON Jika Tejadi Kurang Bayar oleh pasien
    $totDebet		=$jumlahDebet;
    $totKredit		=$jumlahKredit;
    $totTunai		=$tunai;
    $totPerusahaan	=$jumlahNKP;
    $totalYgdibayar	=$totDebet + $totKredit + $totTunai + $totPerusahaan;
    
    
    $nk = $tagihan - $totalYgdibayar;
    
    if($tagihan > $totalYgdibayar){
        
        $insertTcTransKasir["nk"] = $nk;
        
    }else{
        
        $insertTcTransKasir["nk"] =0;
        
    }
    /**************************************************************/
    $insertTcTransKasir["cetak_kartu"] = $cetakKartu;
    $insertTcTransKasir["nd"] = $nd;
    /*if(($kodeKelompok=='4')||($kodeKelompok=='7')){
        if($kodeKelompok=='7'){
            $insertTcTransKasir["nk_kel_karyawan"] = $jumlahNK;
        }else{
            $insertTcTransKasir["nk_karyawan"] = $jumlahNK;
        }
    }*/
    
    $insertTcTransKasir["nk_karyawan"] = $jumlahNK;
    $insertTcTransKasir["nk_pendiri"] = $jumlahNPendiri;
    $insertTcTransKasir["nk_pemegang_saham"] = $jumlahNKPS;
    $insertTcTransKasir["nk_perusahaan"] = $jumlahNKP;
    $insertTcTransKasir["nk_askes"] = $jumlahAskes;		
    $insertTcTransKasir["no_mr_karyawan"] = $penanggung;
    $insertTcTransKasir["no_batch_cc"] = $noBatchKredit;
    /*multiple kredit-------------------------------*/
    $insertTcTransKasir["no_batch_cc1"] = $noBatchKredit1;
    $insertTcTransKasir["no_batch_cc2"] = $noBatchKredit2;
    $insertTcTransKasir["no_batch_cc3"] = $noBatchKredit3;
    $insertTcTransKasir["no_batch_cc4"] = $noBatchKredit4;
    /*---------------------------------------------*/

    $insertTcTransKasir["kd_bank_cc"] = $bankKredit;
    /*multiple kredit-------------------------------*/
    $insertTcTransKasir["kd_bank_cc1"] = $bankKredit1;
    $insertTcTransKasir["kd_bank_cc2"] = $bankKredit2;
    $insertTcTransKasir["kd_bank_cc3"] = $bankKredit3;
    $insertTcTransKasir["kd_bank_cc4"] = $bankKredit4;
    /*---------------------------------------------*/

    $insertTcTransKasir["kd_bank_dc"] = $bankDebet;
    /*multiple debet-------------------------------*/
    $insertTcTransKasir["kd_bank_dc1"] = $bankDebet1;
    $insertTcTransKasir["kd_bank_dc2"] = $bankDebet2;
    $insertTcTransKasir["kd_bank_dc3"] = $bankDebet3;
    $insertTcTransKasir["kd_bank_dc4"] = $bankDebet4;
    /*---------------------------------------------*/

    $insertTcTransKasir["no_batch_dc"] = $noBatchDebet;
    /*multiple debet-------------------------------*/
    $insertTcTransKasir["no_batch_dc1"] = $noBatchDebet1;
    $insertTcTransKasir["no_batch_dc2"] = $noBatchDebet2;
    $insertTcTransKasir["no_batch_dc3"] = $noBatchDebet3;
    $insertTcTransKasir["no_batch_dc3"] = $noBatchDebet4;
    /*---------------------------------------------*/

    $insertTcTransKasir["pembulatan"] = $pembulatan;
    $insertTcTransKasir["nama_pasien"] = $namaPasien;
    $insertTcTransKasir["pembayar"] = $pembayar;
    $keterangan = "Pembayaran antrian loket";
    $insertTcTransKasir["keterangan"] = $keterangan;
    $insertTcTransKasir["kode_shift"] = $shift;
    $insertTcTransKasir["kode_loket"] = $loket;
    $insertTcTransKasir["no_mr"] = $no_mr;
    $insertTcTransKasir["no_registrasi"] = $no_registrasi;
    $insertTcTransKasir["kode_perusahaan"] = $kode_perusahaan;
    
    /*$cek_status_pasien=baca_tabel("mt_master_pasien","status_bpjs"," where no_mr='".$no_mr."'");
    
    if($cek_status_pasien=="1"){
        $insertTcTransKasir["kode_perusahaan"] = AV_PERUSAHAAN_BPJS; 
    }*/
    
    $result = insert_tabel("tc_trans_kasir", $insertTcTransKasir);
    //echo "shift loket:".$insertTcTransKasir["kode_shift"];

    //echo "kode perusahaan:".$kode_perusahaan;

	//////////////////////////////////////////////////////////////////////
	// tc_trans_kasir_bagian
	//////////////////////////////////////////////////////////////////////

	if ($result !== false) {
		foreach ($arrBagian as $key => $kode_bagian) {

			unset($insertTcTransKasirBagian);

			$insertTcTransKasirBagian["kode_tc_trans_kasir"] = $kode_tc_trans_kasir;
			$insertTcTransKasirBagian["kode_bagian"] = $kode_bagian;
			$result = insert_tabel("tc_trans_kasir_bagian", $insertTcTransKasirBagian);

			if ($result === false) break;
		}
	}

	//////////////////////////////////////////////////////////////////////
	// tc_trans_kartu
	//////////////////////////////////////////////////////////////////////
	
	
	if ($result!==false && $biayaKartu>0){
		unset ($editTcTransKartu);
		$editTcTransKartu["flag_bayar"] = 1;
		$result = update_tabel("tc_trans_kartu", $editTcTransKartu, "WHERE no_mr = '$no_mr' AND flag_bayar = 0 AND no_registrasi=$no_registrasi");
	}
	/*

	if (($result !== false) && ($cetakKartu > 0)) {
		unset($editTcTransKartu);

		$editTcTransKartu["flag_bayar"] = 1;
		$result = update_tabel("tc_trans_kartu", $editTcTransKartu, "WHERE no_mr = '$no_mr' AND flag_bayar = 0");
	}
	*/

	//////////////////////////////////////////////////////////////////////
	// tc_trans_pelayanan
	//////////////////////////////////////////////////////////////////////

	if ($result !== false) {
		$daftarKodeBagian = "(";
		foreach ($arrBagian as $key => $kode_bagian) {
			if ($daftarKodeBagian != "(") $daftarKodeBagian .= ",";
			$daftarKodeBagian .= "'$kode_bagian'";
		}
		$daftarKodeBagian .= ")";

		unset($editTcTransPelayanan);

		$status_selesai = 3;

		$editTcTransPelayanan["kode_tc_trans_kasir"] = $kode_tc_trans_kasir;
		$editTcTransPelayanan["status_selesai"] = $status_selesai;

		if($nilaiDiskonnya==0){
			$editTcTransPelayanan["diskon"] =0;
		}

		if (trim($kode_trans_far) != "")
			$sqlWhere = "WHERE kode_trans_far = $kode_trans_far AND status_selesai = 2 AND kode_bagian IN $daftarKodeBagian";
		else
			$sqlWhere = "WHERE no_registrasi = $no_registrasi AND status_selesai = 2  AND kode_bagian IN $daftarKodeBagian";

		$result = update_tabel("tc_trans_pelayanan", $editTcTransPelayanan, $sqlWhere);
	}

	//////////////////////////////////////////////////////////////////////
	if ($result !== false) {
		unset($arrUM);
		$arrUM['kode_tc_trans_kasir_bayar'] = $kode_tc_trans_kasir;
		$arrUM['flag_bayar'] = 1;
		$result = update_tabel("ks_tc_trans_um", $arrUM, "WHERE no_registrasi = $no_registrasi AND kode_tc_trans_kasir_bayar IS NULL");
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if($insertTcTransKasir["nk_perusahaan"] > 0 ){

				$plafon = baca_tabel("tc_registrasi","plafon"," where no_registrasi=".$no_registrasi);
				$saldo_akhir=$plafon - $insertTcTransKasir["nk_perusahaan"];

				$fld=array();

				$fld["id_tc_saldo_asuransi"]	= max_kode_number("tc_saldo_asuransi","id_tc_saldo_asuransi");
				$fld["no_mr"]					= $insertTcTransKasir["no_mr"];
				$fld["kode_perusahaan"]			= $insertTcTransKasir["kode_perusahaan"];
				$fld["saldo_awal"]				= $plafon;
				$fld["pemasukan"]				= "0";
				$fld["pengeluaran"]				= $insertTcTransKasir["nk_perusahaan"];
				$fld["saldo_akhir"]				= $saldo_akhir;
				$fld["id_dd_user"]				= $id_dd_user;
				$fld["tgl_input"]				= date("Y-m-d H:i:s");
				$fld["no_registrasi"]			= $no_registrasi;
				insert_tabel("tc_saldo_asuransi",$fld);
	
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//echo "dd_user".$loginInfo['id_dd_user'];
	//$result = false;
	
	// $link="/10_kasir/cetak_billinga4.php?pembayar=$pembayar&no_kuitansi=$no_kuitansi&no_registrasi=$no_registrasi&kode_kelompok=2&noMR=$no_mr&nama_pasien=$namaPasien&tgl=".date("Y-m-d H:i:s")."&kode_tc_trans_kasir=$kode_tc_trans_kasir&kodeBagian=$kode_bagian&seri_kuitansi=$seri_kuitansi&kodeBagianUtama=$kode_bagian&status_nk=0";
	
	// $linkb="/10_kasir/cetak_billinga_termal.php?pembayar=$pembayar&no_kuitansi=$no_kuitansi&no_registrasi=$no_registrasi&kode_kelompok=2&noMR=$no_mr&nama_pasien=$namaPasien&tgl=".date("Y-m-d H:i:s")."&kode_tc_trans_kasir=$kode_tc_trans_kasir&kodeBagian=$kode_bagian&seri_kuitansi=$seri_kuitansi&kodeBagianUtama=$kode_bagian&status_nk=0";
	
	// $db->CommitTrans($result !== false);
//die;
	if($result){
		$data['code']=200;
		$data['msg']="Berhasil";
	}else{
		$data['code']=500;
		$data['msg']='Gagal';
	}
	echo json_encode($data);
?>