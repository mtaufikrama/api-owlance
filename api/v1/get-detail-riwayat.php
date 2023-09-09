<?php

include "cek-token.php";

//$db->debug=true;
// $input = json_decode(file_get_contents('php://input'),TRUE);

// $id = $input['id'];

/* --- get px from Registrasi --- */
$cek_px = "select no_registrasi,no_mr from tc_registrasi where no_registrasi='$id'";
$dt_px = $db->Execute($cek_px);
$no_registrasi=$dt_px->Fields('no_registrasi');
$no_mr=$dt_px->Fields('no_mr');
$qry_px = &$db->Execute("SELECT no_mr,nama_pasien,no_ktp,gol_darah,jen_kelamin,tgl_lhr,alergi,
			almt_ttp_pasien,id_dc_propinsi,id_dc_kota,id_dc_kecamatan,id_dc_kelurahan 
			FROM mt_master_pasien where no_mr='$no_mr'");
$nama_px 				= $qry_px->fields['nama_pasien'];
$nomr_px 				= $qry_px->fields['no_mr'];
$ktp_px					= $qry_px->fields['no_ktp'];
$gol_darah 				= $qry_px->fields["gol_darah"];
$jen_kelamin 			= $qry_px->fields["jen_kelamin"];
$tgl_lhr 				= $qry_px->fields["tgl_lhr"];
$alergi 				= $qry_px->fields["alergi"]; 
$alamat_ttp 			= $qry_px->fields["almt_ttp_pasien"];	
$id_dc_propinsi			= $qry_px->fields["id_dc_propinsi"];
$id_dc_kota				= $qry_px->fields["id_dc_kota"];
$id_dc_kecamatan		= $qry_px->fields["id_dc_kecamatan"];
$id_dc_kelurahan		= $qry_px->fields["id_dc_kelurahan"];

if($jen_kelamin=="P"){
	$gender="Perempuan";
	// $icon="014-girl-7.svg";
}else{
	$gender="Laki-laki";
	// $icon="001-boy.svg";
}
$umur_px = umur($tgl_lhr);

$nama_propinsi=baca_tabel("dc_propinsi","nama_propinsi","WHERE id_dc_propinsi='".$id_dc_propinsi."'");
$nama_kota=baca_tabel("dc_kota","nama_kota","WHERE id_dc_kota='".$id_dc_kota."'");
$nama_kecamatan=baca_tabel("dc_kecamatan","nama_kecamatan","WHERE id_dc_kecamatan='".$id_dc_kecamatan."'");
$nama_kelurahaan=baca_tabel("dc_kelurahan","nama_kelurahan","WHERE id_dc_kelurahan='".$id_dc_kelurahan."'");

if($nama_propinsi=="" ){
	$provinsi == " - ";
}else{
	$provinsi = $nama_propinsi;
}

if($nama_kota=="" ){
	$kota = " - ";
}else{
	$kota = $nama_kota;
}
if($nama_kecamatan=="" ){
	$kecamatan = " - ";
}else{
	$kecamatan = $nama_kecamatan;
}
if($nama_kelurahan=="" ){
	$kelurahan = " - ";
}else{
	$kelurahan = $nama_kelurahan;
}

$alamat_px = $alamat_ttp." Kelurahan ".$kelurahaan." Kecamatan ".$kecamatan." Kab/Kota ".$kota." Provinsi ".$provinsi;

$dpx['nama_px']    = $nama_px;
$dpx['nomr_px']    = $nomr_px;
$dpx['ktp_px']     = $ktp_px;
$dpx['gender']     = $gender; 
$dpx['gol_darah']  = $gol_darah;
$dpx['umur']       = $umur_px;
$dpx['alergi']	   = $alergi;
$dpx['alamat_px']  = $alamat_px;

$data['px'][] = $dpx;

/* --- get px by IdDaftarKlinik --- */
$cek_px = "select no_registrasi,no_mr,umur from tc_registrasi where no_registrasi='$id'";
$dt_px = $db->Execute($cek_px);
$no_registrasi=$dt_px->Fields('no_registrasi');

/* --- get Vital Sign --- */
$SqlGetVS = "select kode_rujuk_ri,tinggi_badan,lingkar_perut,berat_badan,pernafasan,suhu,nadi,tekanan_darah,kesadaran_pasien,keadaan_umum,no_registrasi from gd_th_rujuk_ri where no_mr='$nomr_px' and no_registrasi='$id'";
$RunGetVS=$db->Execute($SqlGetVS);
while($sqlVS=$RunGetVS->fetchRow()){
	$arrVital[] = $sqlVS;

}
$data['vital_sign']=$arrVital;

/* --- get SOAP --- */
// $SqlGetSOAP="select a.status_pasien as Subyektive,a.terapi as Analyst,b.keterangan as Objective from tc_status_pasien a left join tc_soap b on a.no_registrasi=b.no_registrasi where a.no_registrasi='$id'";
// $RunGetSOAP=$db->Execute($SqlGetSOAP);
// while($TplGetSOAP=$RunGetSOAP->fetchRow()){
// 	$arrSoap[]=$TplGetSOAP;
// }
// $data['soap']=$arrSoap;

/* --- get Tindakan --- */
$not = 1;
$SqlgetTindakan="SELECT nama_tindakan FROM tc_trans_pelayanan WHERE kode_bagian <>'".AV_MCU."' AND jenis_tindakan != 9 AND no_registrasi='$id'";
$RungetTindakan=$db->Execute($SqlgetTindakan);
while($tdk=$RungetTindakan->fetchRow()){
	$arrTin['no_tdk'] = $not++;
	$arrTin['nama_tindakan']=$tdk['nama_tindakan'];

	$data['tindakan'][]=$arrTin;
}

/* --- get ICD 10 --- */
$noi = 1;
$SqlGetICD="select b.icd_10,b.nama_icd from th_riwayat_pasien a left join mt_master_icd10 b on a.icd_10=b.icd_10 where a.no_registrasi='$id'";
$RunGetICD=$db->Execute($SqlGetICD);
while($IcD10=$RunGetICD->fetchRow()){
	$arrICD['no']=$noi++;
	$arrICD['icd10']=$IcD10['icd_10'];
	$arrICD['nama']=$IcD10['nama_icd'];
	
	$data['icd10'][]=$arrICD;
}

/* --- get Resep --- */
$no = 1;
$SqlGetResep="SELECT a.tgl_pesan,b.* FROM fr_tc_pesan_resep_dr as a 
left join fr_tc_far_detail_dr as b on a.kode_pesan_resep_dr=b.kode_pesan_resep_dr
where  a.no_registrasi=" . $id . " order by a.kode_pesan_resep_dr $sqlAddSem" ;
$noResep = baca_tabel("fr_tc_far_dr","no_resep","WHERE no_registrasi='".$id."'");
$RunGetResep=$db->Execute($SqlGetResep);
while($tampil=$RunGetResep->fetchRow()){
	$kd_tr_resep = $tampil["kd_tr_resep"];
	$kode_pesan_resep_dr = $tampil["kode_pesan_resep_dr"];
	$kode_trans_far = $tampil["kode_trans_far"];
	$jumlah_pesan = $tampil["jumlah_pesan"];
	$jumlah_tebus = $tampil["jumlah_tebus"];
	$kode_brg = $tampil["kode_brg"];
	$nama_dosis = $tampil["nama_dosis"];
	$flag_dosis = $tampil["flag_dosis"];
	$kd_tr_resep_dr = $tampil["kd_tr_resep_dr"];
	$id_tc_far_racikan = $tampil["id_tc_far_racikan"];
	$nama_kesediaan = $tampil["nama_kesediaan"];
	$note = $tampil["note"];
	 $note = $tampil["note"];
		if ($flag_dosis == 1) {
			$ket = "Sebelum Makan";
		} else if ($flag_dosis == 2) {
			$ket = "Sesudah Makan";
		} else if ($flag_dosis == 3) {
			$ket = "Saat Makan";
		} else if ($flag_dosis == 4) {
			$ket = "Tetes";
		} else if ($flag_dosis == 5) {
			$ket = "Oles";
		}
	
		$old_date_timestamp = strtotime($tgl_periksa);
		$tanggal = date('d-m-Y', $old_date_timestamp); 
		$new_date = date('d-m-Y H:i:s', $old_date_timestamp); 
		$new_time = date('H:i:s', $old_date_timestamp); 
		
		$nama_brg = baca_tabel("mt_barang", "nama_brg", "where kode_brg='" . $kode_brg . "' and flag_aktif=1");
		$satuan = baca_tabel("mt_barang", "satuan_kecil", "where kode_brg='" . $kode_brg . "' and flag_aktif=1");
				if ($nama_brg == "") {
					if ($id_tc_far_racikan != "") {
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
				}else{
					
					$satuan = $satuan;
				}
					$dtr["kode_pesan"]=$kode_pesan_resep_dr;
					$dtr['no_resep']=$noResep;
					$dtr["nama_brg"]=$nama_brg;
					$dtr["note"]=$note;
					$dtr["satuan"]=$satuan;
					$dtr["nama_dosis"]=$nama_dosis;
					$dtr["jumlah_pesan"]=$jumlah_pesan;
					$dtr["ket"]=$ket;
					$dtr["no"]=$no++;
					
					$resep[]=$dtr;
}
 
$data['resep']=$resep;

/* --- get Laboratorium --- */
$SqlGetRujukan ="SELECT
	pm_tc_penunjang.kode_penunjang,
	pm_tc_penunjang.id_pm_tc_penunjang,
	pm_tc_penunjang.tgl_daftar,
	pm_tc_penunjang.tgl_isihasil,
	pm_tc_penunjang.kode_bagian,
	pm_tc_penunjang.asal_daftar,
	pm_tc_penunjang.diagnosa,
	pm_tc_penunjang.flag_cetak,
	tc_kunjungan.no_kunjungan
	FROM pm_tc_penunjang INNER JOIN tc_kunjungan
	ON tc_kunjungan.no_kunjungan = pm_tc_penunjang.no_kunjungan
	WHERE tc_kunjungan.no_registrasi='$id' 
	AND asal_daftar is not null
	AND pm_tc_penunjang.kode_bagian=".AV_LABORATORIUM; 

$RunGetRujukan=$db->Execute($SqlGetRujukan);
$i=1;
while($h_lab=$RunGetRujukan->fetchRow()){

	$asal_daftar = $h_lab['asal_daftar'];
	$kp			 = $h_lab['kode_penunjang'];

	if($asal_daftar==AV_MCU){
		$txt_kategori=2;
	}else{
		$txt_kategori=3;
	}

	$file="../_arsip/lab/hasillab_".$kp.".pdf";
	if(file_exists($file)){
		$url_pdf_lab=$url_rs."_arsip/lab/hasillab_".$kp.".pdf";
	}else{
		$url_pdf_lab="500";
	}
	
	$dt_lab['no_urut']				 = $i++;
	$dt_lab['url_rs']				 = $url_rs;
	$dt_lab['url_pdf_lab']			 = $url_pdf_lab;
	$dt_lab['kode_penunjang']		 = $h_lab['kode_penunjang'];
	$dt_lab['id_pm_tc_penunjang'] 	 = $h_lab['id_pm_tc_penunjang'];
	$dt_lab['tgl_isihasil'] 		 = $h_lab['tgl_isihasil'];
	$dt_lab['diagnosa']				 = $h_lab['diagnosa'];
	$dt_lab['flag_cetak']			 = $h_lab['flag_cetak'];
	$dt_lab['no_mr_px']				 = $no_mr;
	$dt_lab['txt_kategori']			 = $txt_kategori;

	$lab[] = $dt_lab;
	
}

$data['hasil_lab'] = $lab;

/* --- get Radiologi --- */

$SqlRadio ="SELECT
	pm_tc_penunjang.kode_penunjang,
	pm_tc_penunjang.id_pm_tc_penunjang,
	pm_tc_penunjang.tgl_daftar,
	pm_tc_penunjang.kode_bagian,
	tc_kunjungan.no_registrasi
	FROM
	pm_tc_penunjang
	INNER JOIN tc_kunjungan ON tc_kunjungan.no_kunjungan = pm_tc_penunjang.no_kunjungan where no_registrasi='$id' and kode_bagian=".AV_RADIOLOGI; 
$RunRadio=$db->Execute($SqlRadio);
$i=1;
while($tampil=$RunRadio->fetchRow()){
	$kd_penunjang_radio=$tampil['kode_penunjang'];
	$arrPenunjang[]=$kd_penunjang_radio;
}
if($kd_penunjang_radio!=""){

	if(is_array($arrPenunjang))	{
		foreach($arrPenunjang as $k=>$v){
			//echo $v;
			$sqlRadiologi="select kode_penunjang,nama_tindakan,kode_tarif,tgl_transaksi,pm_tc_hasilpenunjang.*,kode_master_tarif_detail,tc_trans_pelayanan.kode_trans_pelayanan from tc_trans_pelayanan 
			join pm_tc_hasilpenunjang on tc_trans_pelayanan.kode_trans_pelayanan=pm_tc_hasilpenunjang.kode_trans_pelayanan
			where kode_penunjang='$v';";
							
			//$db->debug=true;					
			$_oR =& $db->Execute($sqlRadiologi);
			//$db->debug=false;
			while ($tampil=$_oR->FetchRow()) {
				//print_r($tampil);
				$no_kunjungan=$tampil['no_kunjungan'];
				$nama_tindakan=$tampil['nama_tindakan'];
				$nama_pemeriksaan=$tampil['nama_pemeriksaan'];
				$hasil=$tampil['hasil'];
				$jen_kel=$tampil['jen_kelamin'];
				$kode_tarif=$tampil['kode_tarif'];
				$kode_master_tarif_detail=$tampil['kode_master_tarif_detail'];
				$kode_trans_pelayanan=$tampil['kode_trans_pelayanan'];
				$kode_tc_hasilpenunjang=baca_tabel("pm_tc_hasilpenunjang","kode_tc_hasilpenunjang"," where kode_trans_pelayanan='$kode_trans_pelayanan'");
				$txt_kategori=1;
				if($jen_kel=='L'){
					$standar_hasil=$tampil['standar_hasil_pria']; 
				}else{
					$standar_hasil=$tampil['standar_hasil_wanita']; 
				}
					
				$satuan=$tampil['satuan'];
				$ket=$tampil['keterangan'];
				$foto=$tampil['foto'];
				$kesimpulan=$tampil['kesimpulan'];
				$kesan=$tampil['kesimpulan'];
				$kd_penunjang_radio=$tampil['kode_penunjang'];
				$kdtarif=$tampil['kode_tarif'];

				$file="../_arsip/lab/hasilrad_".$kode_tc_hasilpenunjang.".pdf";
				if(file_exists($file)){
					$url_pdf_rad=$url_rs."_arsip/lab/hasilrad_".$kode_tc_hasilpenunjang.".pdf";
				}else{
					$url_pdf_rad="500";
				}
				
				if (strpos(strtoupper($nama_tindakan), 'THORAX') !== false) {
						$jmlThorax=1;
				}else if(strpos(strtoupper($nama_tindakan), 'USG') !== false){
						$jmlThorax=2;
				}else{
					$jmlThorax=0;
				}

				$dt_rad['no_urut'] = $i++;
				$dt_rad['url_rs'] = $url_rs;
				$dt_rad['url_pdf_rad'] = $url_pdf_rad;
				$dt_rad['nama_tindakan_rad'] = $nama_tindakan;
				$dt_rad['kesimpulan_rad'] = $kesimpulan;
				$dt_rad['kesan_rad'] = $kesan;
				$dt_rad['kode_penunjang_rad'] =  $kd_penunjang_radio;
				$dt_rad['kode_tc_hasilpenunjang'] = $kode_tc_hasilpenunjang;
				$dt_rad['txt_kategori'] = $txt_kategori;
				$dt_rad['jml_thorax'] = $jmlThorax;
				$dt_rad['kode_tarif_rad'] = $kode_tarif;
				
				$rad[]=$dt_rad;
			}
		}
	}
}
	
$data['hasil_rad']=$rad;

if($data['vital_sign'] =="" || $data['tindakan'] ==""){
    $data['code']=500;
    $data['msg']="Vital Sign atau Tindakan masih kosong";
}else{
    $data['code']=200;
}
echo json_encode($data);
?>