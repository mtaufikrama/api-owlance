<?php

include 'cek-token.php';
// $db->debug=true;

// no_registrasi, url

$no_mr = baca_tabel('tc_registrasi', 'no_mr', "where no_registrasi='$no_registrasi'");
$no_kunjungan = baca_tabel('tc_kunjungan', 'no_kunjungan', "where no_registrasi=$no_registrasi");

$sql_pasien = "SELECT no_mr,url_foto_pasien as foto, nama_pasien,gol_darah,jen_kelamin,tgl_lhr,alergi,
almt_ttp_pasien as alamat,id_dc_propinsi as provinsi,id_dc_kota as kota,id_dc_kecamatan as kecamatan,id_dc_kelurahan as kelurahan
FROM mt_master_pasien where no_mr='$no_mr'";

$run_pasien = $db->Execute($sql_pasien);

while($get_pasien=$run_pasien->fetchRow()) {
    $get_pasien['umur'] = umur($get_pasien['tgl_lhr']);
    $get_pasien['foto'] = $url . $get_pasien['foto'];
    $get_pasien['tgl_lhr'] = substr($get_pasien['tgl_lhr'], 0, 10);
    $get_pasien['provinsi'] = baca_tabel('dc_propinsi', 'nama_propinsi', "where id_dc_propinsi='" . $get_pasien['provinsi'] . "'");
    $get_pasien['kota'] = baca_tabel('dc_kota', 'nama_kota', "where id_dc_kota='" . $get_pasien['kota'] . "'");
    $get_pasien['kecamatan'] = baca_tabel('dc_kecamatan', 'nama_kecamatan', "where id_dc_kecamatan='" . $get_pasien['kecamatan'] . "'");
    $get_pasien['kode_pos'] = baca_tabel('dc_kelurahan', 'kode_pos', "where id_dc_kelurahan='" . $get_pasien['kelurahan'] . "'");
    $get_pasien['kelurahan'] = baca_tabel('dc_kelurahan', 'nama_kelurahan', "where id_dc_kelurahan='" . $get_pasien['kelurahan'] . "'");
    $get_pasien['alamat'] = $get_pasien['alamat'].", ".$get_pasien['kelurahan'].", ".$get_pasien['kecamatan'].", ".$get_pasien['kota'].", ".$get_pasien['provinsi'] . ", " . $get_pasien['kode_pos'];
    $pasien=$get_pasien;
}

/* --- get Vital Sign --- */
$sql_vs="SELECT keadaan_umum,kesadaran_pasien,tekanan_darah,nadi,suhu,pernafasan,tinggi_badan,berat_badan 
from gd_th_rujuk_ri where no_registrasi='$no_registrasi'";
$run_vs=$db->Execute($sql_vs);
while($get_vs=$run_vs->fetchRow()) {
    $vs = $get_vs;
}

/* --- get SOAP --- */
$sql_soap="SELECT a.status_pasien as Subyektive,a.terapi as Analyst,b.keterangan as Objective from 
tc_status_pasien a left join tc_soap b on a.no_registrasi=b.no_registrasi where a.no_registrasi='$no_registrasi'";
$run_soap=$db->Execute($sql_soap);
// while($TplGetSOAP=$RunGetSOAP->fetchRow()){
// 	$arrSoap[]=$TplGetSOAP;
// }
// $dt_soap[]=$arrSoap;
while($get_soap=$run_soap->fetchRow()) {
    $soap = $get_soap;
}
/* --- get Tindakan --- */
$not = 1;
$SqlgetTindakan="SELECT bill_rs, bill_dr1, bill_dr2, kode_dokter1, kode_perawat, tgl_transaksi, kode_trans_pelayanan, 
nama_tindakan FROM tc_trans_pelayanan where no_mr='$no_mr' AND no_kunjungan=$no_kunjungan AND kode_bagian like '01%'";

$RungetTindakan=$db->Execute($SqlgetTindakan);
while($tampil=$RungetTindakan->fetchRow()) {
    $kode_trans_pelayanan = $tampil["kode_trans_pelayanan"];
    // $kode_tc_trans_kasir = $tampil["kode_tc_trans_kasir"];
    // $no_kunjungan = $tampil["no_kunjungan"];
    // $no_registrasi = $tampil["no_registrasi"];
    // $no_mr = $tampil["no_mr"];
    // $kode_kelompok = $tampil["kode_kelompok"];
    // $kode_perusahaan = $tampil["kode_perusahaan"];
    $tgl_transaksi = $tampil["tgl_transaksi"];
    // $jenis_tindakan = $tampil["jenis_tindakan"];
    $nama_tindakan = $tampil["nama_tindakan"];
    $bill_rs = $tampil["bill_rs"];
    $bill_dr1 = $tampil["bill_dr1"];
    $bill_dr2 = $tampil["bill_dr2"];
    $kode_dokter1 = $tampil["kode_dokter1"];
    $kode_perawat = $tampil["kode_perawat"];
    //$kode_gd = $tampil["kode_gd"];
    // $kode_tarif = $tampil["kode_tarif"];
    // $kode_master_tarif_detail = $tampil["kode_master_tarif_detail"];
    // $kd_tr_resep = $tampil["kd_tr_resep"];
    $biaya=$bill_rs+$bill_dr1+$bill_dr2;
    if (trim($kode_dokter1)=="") {
        $nama_dokter = "-";
    } else {
        $nama_dokter=baca_tabel("mt_karyawan", "nama_pegawai", "where kode_dokter=$kode_dokter1");
    }

    if (trim($kode_perawat)=="") {
        $nama_perawat = "-";
    } else {
        $nama_perawat=baca_tabel("mt_karyawan", "nama_pegawai", "where kode_perawat='$kode_perawat'");
    }


    //$fungsi_del="modal('dokter_act.php?kode_dokter=$kode_dokter&act=delete')";
    //$fungsi_edt="modal('dokter_addedit.php?kode_dokter=$kode_dokter&act=delete')";
    $old_date_timestamp = strtotime($tgl_transaksi);
    $tanggal = date('d-m-Y', $old_date_timestamp);
    $new_date = date('d-m-Y H:i:s', $old_date_timestamp);
    $new_time = date('H:i:s', $old_date_timestamp);

    $q["id_pelayanan"]=$kode_trans_pelayanan;
    $q["nama_tindakan"]=$nama_tindakan;
    $q["biaya"]=$biaya;
    $q["tanggal"]=$tanggal;
    $q["no"]=$not++;

    $tindakan[]=$q;
}

/* --- get ICD 10 --- */
$noi = 1;
$Sql_icd10="SELECT kode_icd_pasien as id_icd_pasien, kode_icd, kelompok_icd, kode_asterik from th_icd10_pasien 
where no_registrasi=$no_registrasi";
$run_icd10=$db->Execute($Sql_icd10);
while($get_icd10=$run_icd10->fetchRow()) {
    $get_icd10['no']=$noi++;
    $nama_kelompok = baca_tabel("mt_master_icd10", "nama_icd", "where icd_10='".$get_icd10['kelompok_icd']."'");
    $nama_icd10 = baca_tabel("mt_master_icd10", "nama_icd", "where icd_10='".$get_icd10['kode_icd']."'");
    $nama_asterik = baca_tabel("mt_master_icd10", "nama_icd", "where icd_10='".$get_icd10['kode_asterik']."'");
    if ($nama_asterik && $nama_asterik != '') {
        $get_icd10['nama_asterik'] = $nama_asterik;
    } else {
        $get_icd10['nama_asterik'] = null;
    }
    if ($nama_kelompok && $nama_kelompok != '') {
        $get_icd10['nama_kelompok'] = $nama_kelompok;
    } else {
        $get_icd10['nama_kelompok'] = null;
    }
    if ($nama_icd10 && $nama_icd10 != '') {
        $get_icd10['nama_icd10'] = $nama_icd10;
    } else {
        $get_icd10['nama_icd10'] = null;
    }
    $icd10[]=$get_icd10;
}

/* --- get Resep --- */
$no = 1;
$sql_resep="SELECT a.tgl_pesan, b.flag_dosis, b.note, b.kode_brg, b.kd_tr_resep_dr,
b.nama_brg, b.id_tc_far_racikan, b.nama_kesediaan
FROM fr_tc_pesan_resep_dr as a left join fr_tc_far_detail_dr as b on a.kode_pesan_resep_dr=b.kode_pesan_resep_dr
where  a.no_registrasi=" . $no_registrasi . " order by a.kode_pesan_resep_dr";
$run_resep=$db->Execute($sql_resep);
while($get_resep=$run_resep->fetchRow()) {
    $kd_tr_resep_dr = $get_resep["kd_tr_resep_dr"];
    // $kode_pesan_resep_dr = $get_resep["kode_pesan_resep_dr"];
    // $kode_trans_far = $get_resep["kode_trans_far"];
    // $jumlah_pesan = $get_resep["jumlah_pesan"];
    // $jumlah_tebus = $get_resep["jumlah_tebus"];
    $kode_brg = $get_resep["kode_brg"];
    $tgl_pesan = $get_resep["tgl_pesan"];
    $flag_dosis = $get_resep["flag_dosis"];
    $id_tc_far_racikan = $get_resep["id_tc_far_racikan"];
    $nama_kesediaan = $get_resep["nama_kesediaan"];
    $note = $get_resep["note"];
    if ($flag_dosis == 1) {
        $ket = "Sebelum Makan";
    } elseif ($flag_dosis == 2) {
        $ket = "Sesudah Makan";
    } elseif ($flag_dosis == 3) {
        $ket = "Saat Makan";
    } elseif ($flag_dosis == 4) {
        $ket = "Tetes";
    } elseif ($flag_dosis == 5) {
        $ket = "Oles";
    }

    $old_date_timestamp = strtotime($tgl_pesan);
    $tanggal = date('d-m-Y', $old_date_timestamp);
    $new_date = date('d-m-Y H:i:s', $old_date_timestamp);
    $new_time = date('H:i:s', $old_date_timestamp);

    if ($kode_brg) {

        $nama_brg = baca_tabel("mt_barang", "nama_brg", "where kode_brg='" . $kode_brg . "' and flag_aktif=1");
        $satuan = baca_tabel("mt_barang", "satuan_kecil", "where kode_brg='" . $kode_brg . "' and flag_aktif=1");
    }
    if ($nama_brg == "") {

        if ($id_tc_far_racikan) {

            $nama_brg = baca_tabel("tc_far_racikan", "nama_racikan", "where id_tc_far_racikan=" . $id_tc_far_racikan);
            $nama_dosis = baca_tabel("tc_far_racikan", "nama_dosis", "where id_tc_far_racikan=" . $id_tc_far_racikan);
            $flag_dosis = baca_tabel("tc_far_racikan", "flag_dosis", "where id_tc_far_racikan=" . $id_tc_far_racikan);
        }
    }

    if ($kode_brg == "") {
        if ($id_tc_far_racikan != "") {
            //$satuan = baca_tabel("tc_far_racikan", "satuan_kecil", "where id_tc_far_racikan=" . $id_tc_far_racikan);
        }
        $satuan = $nama_kesediaan;
    } else {
        $satuan = $satuan;
    }
    $dtr['id_resep']=$kd_tr_resep_dr;
    $dtr['id_obat']=$kode_brg;
    $dtr["nama_brg"]=$nama_brg;
    $dtr["note"]=$note;
    $dtr["satuan"]=$satuan;
    $dtr["nama_dosis"]=$nama_dosis;
    $dtr["jumlah_pesan"]=$jumlah_pesan;
    $dtr["ket"]=$ket;
    $dtr["no"]=$no++;
    $resep[]=$dtr;
}

$kode_pesan_resep_dr=baca_tabel("fr_tc_pesan_resep_dr", "kode_pesan_resep_dr", " where no_registrasi=$no_registrasi");
$no_kunjungan=baca_tabel("tc_kunjungan", "no_kunjungan", " where no_registrasi=$no_registrasi");

// $data['resep']=$resep;

/* --- get Laboratorium --- */
// $SqlGetRujukan ="SELECT
// 	pm_tc_penunjang.kode_penunjang,
// 	pm_tc_penunjang.id_pm_tc_penunjang,
// 	pm_tc_penunjang.tgl_daftar,
// 	pm_tc_penunjang.kode_bagian,
// 	pm_tc_penunjang.asal_daftar,
// 	pm_tc_penunjang.diagnosa,
// 	pm_tc_penunjang.flag_cetak,
// 	tc_kunjungan.no_kunjungan
// 	FROM pm_tc_penunjang INNER JOIN tc_kunjungan
// 	ON tc_kunjungan.no_kunjungan = pm_tc_penunjang.no_kunjungan
// 	WHERE tc_kunjungan.no_registrasi='$no_registrasi'
// 	AND asal_daftar is not null
// 	AND pm_tc_penunjang.kode_bagian=".AV_LABORATORIUM;

// $RunGetRujukan=$db->Execute($SqlGetRujukan);
// $i=1;
// while($h_lab=$RunGetRujukan->fetchRow()){

// 	$asal_daftar = $h_lab['asal_daftar'];
// 	$kp			 = $h_lab['kode_penunjang'];

// 	if($asal_daftar==AV_MCU){
// 		$txt_kategori=2;
// 	}else{
// 		$txt_kategori=3;
// 	}

// 	$file="../_arsip/lab/hasillab_".$kp.".pdf";
// 	if(file_exists($file)){
// 		$url_pdf_lab=$url_rs."_arsip/lab/hasillab_".$kp.".pdf";
// 	}else{
// 		$url_pdf_lab="500";
// 	}

// 	$dt_lab['no_urut']				 = $i++;
// 	$dt_lab['url_rs']				 = $url_rs;
// 	$dt_lab['url_pdf_lab']			 = $url_pdf_lab;
// 	$dt_lab['kode_penunjang']		 = $h_lab['kode_penunjang'];
// 	$dt_lab['id_pm_tc_penunjang'] 	 = $h_lab['id_pm_tc_penunjang'];
// 	$dt_lab['diagnosa']				 = $h_lab['diagnosa'];
// 	$dt_lab['flag_cetak']			 = $h_lab['flag_cetak'];
// 	$dt_lab['no_mr_px']				 = $no_mr;
// 	$dt_lab['txt_kategori']			 = $txt_kategori;

// 	$lab[] = $dt_lab;

// }

// // $data['hasil_lab'] = $lab;

// /* --- get Radiologi --- */

// $SqlRadio ="SELECT
// 	pm_tc_penunjang.kode_penunjang,
// 	pm_tc_penunjang.id_pm_tc_penunjang,
// 	pm_tc_penunjang.tgl_daftar,
// 	pm_tc_penunjang.kode_bagian,
// 	tc_kunjungan.no_registrasi
// 	FROM
// 	pm_tc_penunjang
// 	INNER JOIN tc_kunjungan ON tc_kunjungan.no_kunjungan = pm_tc_penunjang.no_kunjungan where no_registrasi='$no_registrasi' and kode_bagian=".AV_RADIOLOGI;
// $RunRadio=$db->Execute($SqlRadio);
// $i=1;
// while($get_resep=$RunRadio->fetchRow()){
// 	$kd_penunjang_radio=$get_resep['kode_penunjang'];
// 	$arrPenunjang[]=$kd_penunjang_radio;
// }
// if($kd_penunjang_radio!=""){

// 	if(is_array($arrPenunjang))	{
// 		foreach($arrPenunjang as $k=>$v){
// 			//echo $v;
// 			$sqlRadiologi="select kode_penunjang,nama_tindakan,kode_tarif,tgl_transaksi,pm_tc_hasilpenunjang.*,kode_master_tarif_detail,tc_trans_pelayanan.kode_trans_pelayanan from tc_trans_pelayanan
// 			join pm_tc_hasilpenunjang on tc_trans_pelayanan.kode_trans_pelayanan=pm_tc_hasilpenunjang.kode_trans_pelayanan
// 			where kode_penunjang='$v';";

// 			//$db->debug=true;
// 			$_oR =& $db->Execute($sqlRadiologi);
// 			//$db->debug=false;
// 			while ($get_resep=$_oR->FetchRow()) {
// 				//print_r($get_resep);
// 				$no_kunjungan=$get_resep['no_kunjungan'];
// 				$nama_tindakan=$get_resep['nama_tindakan'];
// 				$nama_pemeriksaan=$get_resep['nama_pemeriksaan'];
// 				$hasil=$get_resep['hasil'];
// 				$jen_kel=$get_resep['jen_kelamin'];
// 				$kode_tarif=$get_resep['kode_tarif'];
// 				$kode_master_tarif_detail=$get_resep['kode_master_tarif_detail'];
// 				$kode_trans_pelayanan=$get_resep['kode_trans_pelayanan'];
// 				$kode_tc_hasilpenunjang=baca_tabel("pm_tc_hasilpenunjang","kode_tc_hasilpenunjang"," where kode_trans_pelayanan='$kode_trans_pelayanan'");
// 				$txt_kategori=1;
// 				if($jen_kel=='L'){
// 					$standar_hasil=$get_resep['standar_hasil_pria'];
// 				}else{
// 					$standar_hasil=$get_resep['standar_hasil_wanita'];
// 				}

// 				$satuan=$get_resep['satuan'];
// 				$ket=$get_resep['keterangan'];
// 				$foto=$get_resep['foto'];
// 				$kesimpulan=$get_resep['kesimpulan'];
// 				$kesan=$get_resep['kesimpulan'];
// 				$kd_penunjang_radio=$get_resep['kode_penunjang'];
// 				$kdtarif=$get_resep['kode_tarif'];

// 				$file="../_arsip/lab/hasilrad_".$kode_tc_hasilpenunjang.".pdf";
// 				if(file_exists($file)){
// 					$url_pdf_rad=$url_rs."_arsip/lab/hasilrad_".$kode_tc_hasilpenunjang.".pdf";
// 				}else{
// 					$url_pdf_rad="500";
// 				}

// 				if (strpos(strtoupper($nama_tindakan), 'THORAX') !== false) {
// 						$jmlThorax=1;
// 				}else if(strpos(strtoupper($nama_tindakan), 'USG') !== false){
// 						$jmlThorax=2;
// 				}else{
// 					$jmlThorax=0;
// 				}

// 				$dt_rad['no_urut'] = $i++;
// 				$dt_rad['url_rs'] = $url_rs;
// 				$dt_rad['url_pdf_rad'] = $url_pdf_rad;
// 				$dt_rad['nama_tindakan_rad'] = $nama_tindakan;
// 				$dt_rad['kesimpulan_rad'] = $kesimpulan;
// 				$dt_rad['kesan_rad'] = $kesan;
// 				$dt_rad['kode_penunjang_rad'] =  $kd_penunjang_radio;
// 				$dt_rad['kode_tc_hasilpenunjang'] = $kode_tc_hasilpenunjang;
// 				$dt_rad['txt_kategori'] = $txt_kategori;
// 				$dt_rad['jml_thorax'] = $jmlThorax;
// 				$dt_rad['kode_tarif_rad'] = $kode_tarif;

// 				$rad[]=$dt_rad;
// 			}
// 		}
// 	}
// }

// $data['hasil_rad']=$rad;


$data['code']=200;
$data['pasien'] = $pasien;
$data['vital_sign'] = $vs;
$data['riwayat_pemeriksaan'] = $soap;
$data['tindakan'] = $tindakan;
$data['icd10'] = $icd10;
$data['resep'] = $resep;
// $data['dt_lab'] = $lab;
// $data['dt_rad'] = $rad;
echo json_encode($data);
