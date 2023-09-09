<?php

include "cek-token.php";
include "../../_lib/class/Barang.php";
//no_registrasi, id_dc_kesediaan_obat, kode_brg, kode_brg_racikan, id_dd_dosis, txt_jumlah, id_stok, flag_dosis 

$kode_bagian_far=AV_FARMASI;
//echo "$kode_bagian";
$kode_dokter=baca_tabel('tc_registrasi', 'kode_dokter', "where no_registrasi=$no_registrasi");
$no_kunjungan=baca_tabel('tc_kunjungan', 'no_kunjungan', "where no_registrasi=$no_registrasi");
$no_mr=baca_tabel('tc_kunjungan', 'no_mr', "where no_registrasi=$no_registrasi");
$kode_bagian=baca_tabel('tc_registrasi', 'kode_bagian_masuk', "where no_registrasi=$no_registrasi");
$diagnosa=baca_tabel("th_riwayat_pasien", "diagnosa_akhir", "WHERE no_registrasi=$no_registrasi");
$kode_bagian_asal_far=baca_tabel('tc_registrasi', 'kode_bagian_masuk', "where no_registrasi=$no_registrasi");

if (substr($kode_bagian, 0, 2) == '03') {
    $tipeRL = 'B';
} else {
    $tipeRL = 'A';
}
//=============================================================//
$data_pasien= data_tabel("mt_master_pasien", "where no_mr='".$no_mr."'");

$icd_10 = baca_tabel('th_icd10_pasien', 'kode_icd', "where no_registrasi=$no_registrasi");

$tgl_periksa=date('Y-m-d H:i:s');
if($icd_10=="") {
    $diagnosa_icd=$diagnosa;
} else {
    $diagnosa_icd=  baca_tabel("mt_master_icd10", "nama_icd", "where icd_10='".$icd_10."'");
}

if($kode_dokter !="") {
    $sql=read_tabel("mt_karyawan", "*", "where kode_dokter='$kode_dokter'");
    while ($tampil=$sql->FetchRow()) {
        $nama_pegawai		= $tampil["nama_pegawai"];
        $kode_spesialisasi	= $tampil["kode_spesialisasi"];
        $url_foto_karyawan	= $tampil["url_foto_karyawan"];

    }

    $nama_spesialisasi=baca_tabel("mt_spesialisasi_dokter", "nama_spesialisasi", " where kode_spesialisasi=$kode_spesialisasi");

} else {
    $nama_pegawai="";
    $nama_spesialisasi="-";

}

$cek=baca_tabel("fr_tc_pesan_resep_dr","kode_pesan_resep_dr"," where no_kunjungan=$no_kunjungan  order by kode_pesan_resep_dr desc");
    if($cek==""){
			// $result = true;
			// $db->BeginTrans();
			//////////////////////////////////////////////////////////////////////
			unset($insertFrTcPesanResep);
			$kode_pesan_resep_dr = max_kode_number("fr_tc_pesan_resep_dr", "CAST(kode_pesan_resep_dr as INT)");
			$insertFrTcPesanResep["kode_pesan_resep_dr"] = $kode_pesan_resep_dr;
			$insertFrTcPesanResep["kode_dokter"] = $kode_dokter;
			/*if ($kode_bagian == "") {

				$potongkodebagian = substr($kode_bagian_asal, 0, 2);

				if ($potongkodebagian == "01") {

					$kode_bagian = AV_FARMASIRJ;

				} else {

					$kode_bagian = AV_FARMASIRI;

				}

			}*/

			$date=date("Y-m-d");
			$tahun=date("Y");

			//$no_registrasi=baca_tabel("tc_kunjungan","no_registrasi"," where no_kunjungan=".$no_kunjungan);

			$insertFrTcPesanResep["tgl_pesan"] 			= $dateN;
			$insertFrTcPesanResep["jumlah_r"] 			= 1;
			$insertFrTcPesanResep["lokasi_tebus"] 		= 1;
			$insertFrTcPesanResep["no_kunjungan"] 		= $no_kunjungan;
			$insertFrTcPesanResep["no_registrasi"] 		= $no_registrasi ;
			$insertFrTcPesanResep["no_mr"] 				= $no_mr;
			$insertFrTcPesanResep["kode_perusahaan"] 	= $kode_perusahaan;
			$insertFrTcPesanResep["kode_kelompok"] 		= $kode_kelompok;
			$insertFrTcPesanResep["kode_klas"] 			= $kode_klas;
			$insertFrTcPesanResep["kode_bagian"] 		= $kode_bagian_far;
			$insertFrTcPesanResep["kode_bagian_asal"] 	= $kode_bagian;
			$insertFrTcPesanResep["kode_profit"] 		= 2000;
			$insertFrTcPesanResep["status_resep"] 		= 1;
			$no = max_kode_number("fr_tc_pesan_resep_dr", "CAST(no_resep as INT)", "where YEAR(tgl_pesan)=$tahun");
			// $no = $no + 1;
			$insertFrTcPesanResep["no_resep"] = $no;
			$result = insert_tabel("fr_tc_pesan_resep_dr", $insertFrTcPesanResep);
			
			//////////////////////////////////////////////////////////////////////

			$kode_trans_far_dr = max_kode_number("fr_tc_far_dr", "CAST(kode_trans_far_dr as INT)", "");
			$kode_form_rl = 0;
			$kode_form_bb = 0;
			$no_form = $no . "/$tahun";
			$txt_nama_pasien = baca_tabel("mt_master_pasien", "nama_pasien", "WHERE no_mr='" . $no_mr . "'");
			$txt_telp = baca_tabel("mt_master_pasien", "tlp_almt_ttp", "WHERE no_mr='" . $no_mr . "'");
			$txt_alamat = baca_tabel("mt_master_pasien", "almt_ttp_pasien", "WHERE no_mr='" . $no_mr . "'");
			$txt_dokter_pengirim = baca_tabel("mt_karyawan", "nama_pegawai", "WHERE kode_dokter='" . $kode_dokter."'");

			//////////////////////////////////////////////////////////////////////

			unset($insertFrTcFar);
			$insertFrTcFar["kode_trans_far_dr"] = $kode_trans_far_dr;
			$insertFrTcFar["kode_pesan_resep_dr"] = $kode_pesan_resep_dr;
			$insertFrTcFar["kode_form_ri"] = $kode_form_ri;
			$insertFrTcFar["kode_form_rj"] = $kode_form_rj;
			$insertFrTcFar["kode_form_rl"] = $kode_form_rl;
			$insertFrTcFar["kode_form_bb"] = $kode_form_bb;
			$insertFrTcFar["no_resep"] = $no_form;
			$insertFrTcFar["tgl_transaksi"] = $dateN;
			$insertFrTcFar["petugas"] = $petugas;
			$insertFrTcFar["no_mr"] = $no_mr;
			$insertFrTcFar["no_registrasi"] = $no_registrasi;
			$insertFrTcFar["no_kunjungan"] = $no_kunjungan;
			$insertFrTcFar["kode_dokter"] = $kode_dokter;
			$insertFrTcFar["nama_pasien"] = $txt_nama_pasien;
			$insertFrTcFar["alamat_pasien"] = $txt_alamat;
			$insertFrTcFar["telpon_pasien"] = $txt_telp;
			$insertFrTcFar["dokter_pengirim"] = $txt_dokter_pengirim;
			$insertFrTcFar["kode_bagian"] = $kode_bagian_far;
			$insertFrTcFar["kode_bagian_asal"] = $kode_bagian;
			$insertFrTcFar["kode_profit"] = 2000;
			$result = insert_tabel("fr_tc_far_dr", $insertFrTcFar);

			//////////////////////////////////////////////////////////////////////

			//$result=false;

        }

$kode_pesan_resep_dr = baca_tabel('fr_tc_pesan_resep_dr','kode_pesan_resep_dr',"where no_kunjungan=$no_kunjungan");

$sql = "SELECT no_mr, nama_pasien, tgl_lhr, umur_pasien, jen_kelamin, status_bpjs, kode_kelompok FROM mt_master_pasien where no_mr='$no_mr'";

$run = $db->Execute($sql);

$no_mr = $run->fields["no_mr"];
$nama_pasien = $run->fields["nama_pasien"];
$tgl_lhr = $run->fields["tgl_lhr"];
$umur = $run->fields["umur_pasien"];
$jen_kelamin = $run->fields["jen_kelamin"];
$flag_aktif_bpjs=$run->fields("status_bpjs");
$kode_kelompok=$run->fields("kode_kelompok");


// $result = false;
// $db->BeginTrans();

unset($insertFrTcFarDetailDr);

/* $arr_data = harga_far($kode_profit, $kode_bagian, $no_mr, $txt_kd_brg, $kode_klas);
$harga_beli = $arr_data["harga_beli"];
$harga_jual = $arr_data["harga_jual"]; */

$harga_jual = baca_tabel("mt_barang", "harga_jual", "where kode_brg='" . $kode_brg . "' and flag_aktif=1");

if($kode_kelompok == AV_KODE_NASABAH_BPJS && $flag_aktif_bpjs == '1') {
    $harga_jual=0;
    $harga_beli=0;
    $txt_service=0;
    $biaya_tebus=0;
}

$biaya_tebus = $harga_jual * $txt_jumlah;
$kd_tr_resep_dr = max_kode_number("fr_tc_far_detail_dr", "kd_tr_resep_dr", "");


$insertFrTcFarDetailDr["kd_tr_resep_dr"] = $kd_tr_resep_dr;
$insertFrTcFarDetailDr["kode_pesan_resep_dr"] = $kode_pesan_resep_dr;
$insertFrTcFarDetailDr["kd_tr_resep"] = $kd_tr_resep;
$insertFrTcFarDetailDr["kode_trans_far"] = $kode_trans_far;
$insertFrTcFarDetailDr["jumlah_pesan"] = $txt_jumlah;
$insertFrTcFarDetailDr["jumlah_tebus"] = $txt_jumlah;
$insertFrTcFarDetailDr["harga_r"] = $txt_service;
$insertFrTcFarDetailDr["sisa"] = $sisa;
$insertFrTcFarDetailDr["jumlah_retur"] = $jumlah_retur;
$insertFrTcFarDetailDr["harga_r_retur"] = $harga_r_retur;
$insertFrTcFarDetailDr["kode_brg"] = $kode_brg;
$insertFrTcFarDetailDr["harga_beli"] = $harga_beli;
$insertFrTcFarDetailDr["note"] = $note;
$insertFrTcFarDetailDr["harga_jual"] = $harga_jual;
$insertFrTcFarDetailDr["harga_r"] = $txt_service;
$insertFrTcFarDetailDr["biaya_tebus"] = $biaya_tebus;
$insertFrTcFarDetailDr["bill_rs"] = $bill_rs;
$insertFrTcFarDetailDr["bill_dr1"] = $bill_dr1;
$insertFrTcFarDetailDr["bill_dr2"] = $bill_dr2;
$insertFrTcFarDetailDr["bill_rs_askes"] = $bill_rs_askes;
$insertFrTcFarDetailDr["bill_dr1_askes"] = $bill_dr1_askes;
$insertFrTcFarDetailDr["bill_dr2_askes"] = $bill_dr2_askes;
$insertFrTcFarDetailDr["bill_rs_jatah"] = $bill_rs_jatah;
$insertFrTcFarDetailDr["bill_dr1_jatah"] = $bill_dr1_jatah;
$insertFrTcFarDetailDr["bill_dr2_jatah"] = $bill_dr2_jatah;
$insertFrTcFarDetailDr["status_kirim"] = $status_kirim;
$insertFrTcFarDetailDr["status_retur"] = $status_retur;
$insertFrTcFarDetailDr["tgl_input"] = $tgl_input;
$insertFrTcFarDetailDr["id_tc_far_racikan"] = $id_tc_far_racikan;
$insertFrTcFarDetailDr["flag_kjs"] = $flag_kjs;
$insertFrTcFarDetailDr["id_dd_dosis"] = $id_dd_dosis;
$insertFrTcFarDetailDr["id_dd_romawi"] = baca_tabel("dd_romawi", "id_dd_romawi", " where angka_arab=" . $txt_jumlah);
$insertFrTcFarDetailDr["angka_romawi"] = baca_tabel("dd_romawi", "angka_romawi", " where angka_arab=" . $txt_jumlah);
$insertFrTcFarDetailDr["nama_dosis"] = baca_tabel("dd_dosis", "nama_dosis", " where id_dd_dosis=" . $id_dd_dosis);
$insertFrTcFarDetailDr["flag_dosis"] = $flag_dosis;
$insertFrTcFarDetailDr["id_dc_kesediaan_obat"] = $id_dc_kesediaan_obat;
$insertFrTcFarDetailDr["id_dc_areapemakaian_racikan"] = $id_dc_areapemakaian_racikan;

if ($id_dc_areapemakaian_racikan != "") {
    $areapemakaian_racikan = baca_tabel("dc_areapemakaian_racikan", "nama_areapemakaian", "where id_dc_areapemakaian_racikan=" . $id_dc_areapemakaian_racikan);
}
$insertFrTcFarDetailDr["nama_areapemakaian"] = $areapemakaian_racikan;
if ($id_dc_kesediaan_obat != "") {
    $insertFrTcFarDetailDr["nama_kesediaan"] = baca_tabel("dc_kesediaan_obat", "nama_kesediaan", " where id_dc_kesediaan_obat=" . $id_dc_kesediaan_obat);
}

$insertFrTcFarDetailDr["id_dc_kesediaan_obat_det"] = $id_dc_kesediaan_obat_det;

if ($id_dc_kesediaan_obat_det != "") {
    $insertFrTcFarDetailDr["nama_kesediaan_obat_det"] = baca_tabel("dc_kesediaan_obat_det", "nama_kesediaan_obat_det", " where id_dc_kesediaan_obat_det=" . $id_dc_kesediaan_obat_det);
}

$result1 = insert_tabel("fr_tc_far_detail_dr", $insertFrTcFarDetailDr);
//////////////////////////		Insert Pelayanan 		///////////////////////
//Masuk ke farmasi :

$sql = "SELECT * FROM fr_tc_pesan_resep_dr WHERE kode_pesan_resep_dr=" . $kode_pesan_resep_dr;
$hasil = $db->Execute($sql);

$kode_pesan_resep_dr = $hasil->Fields('kode_pesan_resep_dr');
$kode_pesan_resep = $hasil->Fields('kode_pesan_resep');
$kode_dokter = $hasil->Fields('kode_dokter');
$kode_bagian = $hasil->Fields('kode_bagian');
$tgl_pesan = $hasil->Fields('tgl_pesan');
$status_tebus = $hasil->Fields('status_tebus');
$jumlah_r = $hasil->Fields('jumlah_r');
$lokasi_tebus = $hasil->Fields('lokasi_tebus');
$keterangan = $hasil->Fields('keterangan');
$no_registrasi = $hasil->Fields('no_registrasi');
$no_kunjungan = $hasil->Fields('no_kunjungan');
$no_mr = $hasil->Fields('no_mr');
$kode_perusahaan = $hasil->Fields('kode_perusahaan');
$kode_kelompok = $hasil->Fields('kode_kelompok');
$kode_klas = $hasil->Fields('kode_klas');
$kode_profit = $hasil->Fields('kode_profit');
$kode_bagian_asal = $hasil->Fields('kode_bagian_asal');
$status_resep = $hasil->Fields('status_resep');

$kode_trans_pelayanan = max_kode_number("tc_trans_pelayanan", "kode_trans_pelayanan");

$insertXxTrins["kode_trans_pelayanan"] = $kode_trans_pelayanan;
$insertXxTrins["kode_pesan_resep_dr"] = $kode_pesan_resep_dr;
$insertXxTrins["kd_tr_resep_dr"] = $kd_tr_resep_dr;
$insertXxTrins["no_registrasi"] = $no_registrasi;
$insertXxTrins["no_mr"] = $no_mr;
$insertXxTrins["nama_pasien_layan"] = $nama_pasien;
$insertXxTrins["kode_kelompok"] = $kode_kelompok;
$insertXxTrins["kode_perusahaan"] = $kode_perusahaan;
$insertXxTrins["tgl_transaksi"] =date('Y-m-d H:i:s');
$insertXxTrins["jenis_tindakan"] = 11;

$nama_brg = baca_tabel("mt_barang", "nama_brg", "where kode_brg='" . $kode_brg . "' and flag_aktif=1");
$harga_jual = baca_tabel("mt_barang", "harga_jual", "where kode_brg='" . $kode_brg . "' and flag_aktif=1");

if($kode_kelompok == AV_KODE_NASABAH_BPJS && $flag_aktif_bpjs == '1') {
    $harga_jual=0;
}


$biaya_harga_jual = $harga_jual * $txt_jumlah;

$insertXxTrins["nama_tindakan"] = $nama_brg;
$insertXxTrins["bill_rs"] = $biaya_harga_jual;
//echo 'Total Harga : '.$total_harga;
//$insertXxTrins["bill_dr1"] = $bill_dr1;
//$insertXxTrins["bill_dr2"] = $bill_dr2;
$insertXxTrins["lain_lain"] = $harga_r;
$insertXxTrins["kode_dokter1"] = $kode_dokter;
//$insertXxTrins["kode_dokter2"] = $kode_dokter2;
//$insertXxTrins["jumlah"] = $jumlah_tebus;
//$insertXxTrins["kode_ri"] = $kode_ri;
$insertXxTrins["kode_poli"] = $kode_poli;
$insertXxTrins["jumlah"] = $txt_jumlah;
$insertXxTrins["kode_barang"] = $kode_brg;
//$diskon = cek_diskon_obat($no_registrasi, $kode_brg, $kode_bagian);
//$insertXxTrins["diskon"] = $total_harga * $diskon;
//$insertXxTrins["kode_trans_far"] = $kode_trans_far;
$insertXxTrins["kode_bagian"] = $kode_bagian_far;
$insertXxTrins["kode_bagian_asal"] = $kode_bagian_asal_far;
$insertXxTrins["kode_profit"] = $kode_profit;
$insertXxTrins["total_sbl_ppn"] = $total_sbl_ppn;
$insertXxTrins["ppn"] = $ppn;

/* 	$total_harga_kjs=0;
  if($flag_kjs=='10'){


  $insertXxTrins["bill_bs_rs"] = $total_harga_kjs;
  $insertXxTrins["bill_kjs"] = "";
  }else{
  $insertXxTrins["bill_bs_rs"] = $total_harga_kjs;
  $insertXxTrins["bill_kjs"] = "";
  } */

if ($kode_kelompok == '10') {
    $insertXxTrins["status_nk"] = "1";
}


//$insertXxTrins["kode_depo_stok"] = $kode_depo_stok;
//$insertXxTrins["kode_gd"] = $kode_gd;
//$insertXxTrins["kode_master_tarif_detail"] = $kode_master_tarif_detail;
//$insertXxTrins["kode_tarif"] = $kode_tarif;
$insertXxTrins["kd_tr_resep"] = $kd_tr_resep;
$insertXxTrins["id_dd_user"] = $loginInfo["id_dd_user"];
if ($kode_profit == 1000) {
    $insertXxTrins["no_kunjungan"] = $no_kunjungan;
    $insertXxTrins["status_selesai"] = 2;
} elseif ($kode_profit == 2000) {
    $insertXxTrins["no_kunjungan"] = $no_kunjungan;
    $insertXxTrins["status_selesai"] = 2;
} else {
    //$insertXxTrins["no_kunjungan"] = $no_kunjungan;
    $insertXxTrins["status_selesai"] = 2;
}

if ($karyawan == 1) {
    $insertXxTrins["status_karyawan"] = 1;
}

if($result1) {
    $result2 = insert_tabel("tc_trans_pelayanan", $insertXxTrins);
}

//////////////////////////			END 		///////////////////////

///////////////////////////		Update Kurang Stok Depo 	/////////////////////
$no_resep=baca_tabel("fr_tc_far_dr", "no_resep", " where kode_pesan_resep_dr=$kode_pesan_resep_dr");
// $obat = new Barang();
// $obat->kurang_kartu_stok($kode_brg, $txt_jumlah, $kode_bagian_far, 14, "Penjualan No Resep : $no_resep");
// $obat->kurang_depo_stok($kode_brg, $txt_jumlah, $kode_bagian_far);
///////////////////////////		END 	/////////////////////
// $result=false;
// $db->CommitTrans($result!== false);

if($result2) {
    $data['code']=200;
    $data['msg']='Resep Berhasil ditambahkan';
    //$data['code']=$no_registrasi;
} else {
    $data['code']=500;
    $data['msg']='Maaf, Resep Gagal ditambahkan';
}
echo json_encode($data);
?>