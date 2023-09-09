<?php

include "cek-token.php";
include "../../_lib/class/AvObjects.php";
include "../../_lib/class/Tarif.php";
include "../../_lib/class/Barang.php";

//no_registrasi, kode_tarif, jumlah_tindakan, kode_brg, jumlah_obat

$sqlRegis = &$db->Execute("SELECT * FROM tc_registrasi where no_registrasi='$no_registrasi'");
$kode_dokter=$sqlRegis->fields["kode_dokter"];
$kode_kelompok = $sqlRegis->fields["kode_kelompok"];
$kode_perusahaan = $sqlRegis->fields["kode_perusahaan"];
$kode_bagian = $sqlRegis->fields["kode_bagian_masuk"];
$no_mr = $sqlRegis->fields["no_mr"];
$no_kunjungan = baca_tabel('tc_kunjungan','no_kunjungan',"where no_registrasi=$no_registrasi");
$nama_pasien = baca_tabel('mt_master_pasien', 'nama_pasien',"where no_mr='$no_mr'");
$no_induk = baca_tabel('mt_karyawan','no_induk',"where kode_dokter=$kode_dokter");
$id_dd_user = baca_tabel('dd_user', 'id_dd_user',"where no_induk=$no_induk");

if($kode_tarif!='') {
    $sqlTindakan = &$db->Execute("SELECT kode_tarif, nama_tarif, jenis_tindakan, total, pendapatan_rs, bill_dr1 FROM mt_master_tarif where kode_tarif='$kode_tarif'");
    $kode_tarif         =$sqlTindakan->fields["kode_tarif"];
    $nama_tarif         =$sqlTindakan->fields["nama_tarif"];
    $jenis_tindakan     =$sqlTindakan->fields["jenis_tindakan"];
    $total              =$sqlTindakan->fields["total"];
    $pendapatan_rs      =$sqlTindakan->fields["pendapatan_rs"];
    $bill_dr1           =$sqlTindakan->fields["bill_dr1"];
}
//$kode_bagian=baca_tabel('tc_kunjungan','kode_bagian_tujuan',"where no_kunjungan=$no_kunjungan");

// $result = true;
// $db->BeginTrans();
//unset($fld);
$kode_trans_pelayanan=max_kode_number("tc_trans_pelayanan", "kode_trans_pelayanan");

$fld["kode_trans_pelayanan"]		=$kode_trans_pelayanan;
$fld["no_kunjungan"]				=$no_kunjungan;
$fld["no_registrasi"]				=$no_registrasi;
$fld["no_mr"]						=$no_mr;
$fld["nama_pasien_layan"]			=$nama_pasien;
$fld["kode_tarif"]					=$kode_tarif;
$fld["kode_dokter1"]				=$kode_dokter;
$fld["kode_bagian"]					=$kode_bagian;
$fld["kode_bagian_asal"]			=$kode_bagian;
$fld["jenis_tindakan"]				=$jenis_tindakan;
$fld["nama_tindakan"]				=$nama_tarif;
$fld["jumlah"]						=$jumlah_tindakan;
$fld["status_selesai"]				=2;
$fld["kode_kelompok"]				=$kode_kelompok;
$fld["kode_perusahaan"]				=$kode_perusahaan;
$fld["id_dd_user"]					=$id_dd_user;
$fld["tgl_transaksi"]				=date('Y-m-d H:i:s');

$fld["bill_rs"]						= $pendapatan_rs*$jumlah_tindakan;
$fld["bill_dr1"]					= $bill_dr1*$jumlah_tindakan;
$fld["pendapatan_rs"]				= $pendapatan_rs*$jumlah_tindakan;

if($kode_tarif!='') {
    $result = insert_tabel("tc_trans_pelayanan", $fld);
}

$kode_trans_pelayanan1=max_kode_number("tc_trans_pelayanan", "kode_trans_pelayanan");

if ($kode_brg){
    
    $sqlObat = &$db->Execute("SELECT kode_brg, nama_brg, harga_beli FROM mt_barang where kode_brg='$kode_brg'");
    $kode_brg=$sqlObat->fields["kode_brg"];
    $nama_brg=$sqlObat->fields["nama_brg"];
    $harga_beli=$sqlObat->fields["harga_beli"];
    
    $fldObat["kode_trans_pelayanan"]=$kode_trans_pelayanan1;
    $fldObat["no_kunjungan"]=$no_kunjungan;
    $fldObat["no_registrasi"]=$no_registrasi;
    $fldObat["no_mr"]=$no_mr;
    $fldObat["nama_pasien_layan"]=$nama_pasien;
    $fldObat["kode_dokter1"]=$kode_dokter;
    $fldObat["kode_barang"]=$kode_brg;
    $fldObat["kode_bagian"]=$kode_bagian;
    $fldObat["kode_bagian_asal"]=$kode_bagian;
    $fldObat["jenis_tindakan"]=9;
    $fldObat["status_selesai"]=2;
    $fldObat["kode_kelompok"]=$kode_kelompok;
    $fldObat["kode_perusahaan"]=$kode_perusahaan;
    $fldObat["nama_tindakan"]=$nama_brg;
    $fldObat["jumlah"]=$jumlah_obat;
    $fldObat["id_dd_user"]=$id_dd_user;
    $fldObat["tgl_transaksi"]=date('Y-m-d H:i:s');
    
    //$fldObat["bill_rs"]		=;
    $fldObat["bill_dr1"]		=$harga_beli*$jumlah_obat;

}
//$fldObat["pendapatan_rs"]	=;

/*
if($kode_brg!=''){
        $result = insert_tabel("tc_trans_pelayanan", $fldObat);
    }
*/
$jumlah_obat = round($jumlah_obat);
// ---------------- Ini Bagian BPAKO ----------------

if ($kode_brg && is_numeric($jumlah_obat)) {
    unset($fld);

    $kode_trans_pelayanan=max_kode_number("tc_trans_pelayanan", "kode_trans_pelayanan");
    if ($kode_perusahaan=="") {
        $kode_perusahaan="0";
    }

    ///kode profit untuk rawat jalan///////////////////
    $kode_profit=2000;
    //////////////////////////////////////////////////

    $tarifBPAKO = new Tarif();
    $tarifBPAKO->set("kode_barang", $kode_brg);
    $tarifBPAKO->set("jumlah", $jumlah_obat);
    $tarifBPAKO->set("kode_klas", AV_POLI_KODE_KLAS_RAWAT_JALAN);
    $tarifBPAKO->set("kode_kelompok", $kode_kelompok);
    $tarifBPAKO->set("kode_perusahaan", $kode_perusahaan);
    $tarifBPAKO->set("kode_profit", $kode_profit);
    $fld=$tarifBPAKO->hitungBPAKO();
    $keterangan = $nama_pasien." MR:".$no_mr;//DITAMBAH KETERANAGAN
    //show($fld,"Biaya BPAKO");

    $harga_jual=baca_tabel("mt_barang", "harga_jual", " where kode_brg='".$kode_brg."'");
    $fld["kode_trans_pelayanan"]    =$kode_trans_pelayanan;
    $fld["no_kunjungan"]            =$no_kunjungan;
    $fld["no_registrasi"]           =$no_registrasi;
    $fld["no_mr"]                   =$no_mr;
    $fld["nama_pasien_layan"]       =$nama_pasien;
    $fld["kode_perusahaan"]         =$kode_perusahaan;
    $fld["tgl_transaksi"]           =$tgl_sekarang;
    $fld["kode_dokter1"]            =$kode_dokter;
    $fld["kode_bagian"]             =$kode_bagian;
    $fld["status_selesai"]          =2;
    $fld["kode_bagian_asal"]        =$kode_bagian;
    $fld["id_dd_user"]              =$id_dd_user;
    $fld["tgl_transaksi"]           =date('Y-m-d H:i:s');
    $fld["bill_rs"]			        =$harga_jual*$jumlah_obat;

    if ($kode_brg) {
        $result = insert_tabel("tc_trans_pelayanan", $fld);
    }

    if($kode_bagian == AV_REHAB_MEDIK) {
        $obat=new Barang();
        $obat->kurang_kartu_stok($kode_brg, $jumlah_brg, AV_PM_REHAB_MEDIK, 6, $keterangan);//DITAMBAH KETERANAGAN
        $obat->kurang_depo_stok($kode_brg, $jumlah_brg, AV_PM_REHAB_MEDIK);
    } else {
        $obat=new Barang();
        $obat->kurang_kartu_stok($kode_brg, $jumlah_brg, $kode_bagian, 6, $keterangan);//DITAMBAH KETERANAGAN
        $obat->kurang_depo_stok($kode_brg, $jumlah_brg, $kode_bagian);
    }
}

if($result) {
    if ($kode_brg && $kode_tarif){
        $data['code']=200;
        $data['msg']='Tindakan dan Obat Tindakan Berhasil ditambahkan';
    }
    elseif ($kode_brg) {
        $data['code']=200;
        $data['msg']='Obat Tindakan Berhasil ditambahkan';
    } 
    elseif ($kode_tarif) {
        $data['code']=200;
        $data['msg']='Tindakan Berhasil ditambahkan';
    } 
    else {
        $data['code']=500;
        $data['msg']='Maaf, Tindakan dan Obat Tindakan ditambahkan';
    }
} else {
    $data['code']=500;
    $data['msg']='Maaf, Data Gagal ditambahkan';
}

echo json_encode($data);
?>