<?php

include "cek-token.php";

//no_registrasi, subjective, analyst, objective

$no_mr = baca_tabel('tc_kunjungan', 'no_mr', "where no_registrasi=$no_registrasi");
$no_kunjungan = baca_tabel('tc_kunjungan', 'no_kunjungan', "where no_registrasi=$no_registrasi");
$kode_dokter = baca_tabel('tc_kunjungan', 'kode_dokter', "where no_registrasi=$no_registrasi");
$id_tc_status_pasien = baca_tabel('tc_status_pasien', 'id_tc_status_pasien', "where no_kunjungan=$no_kunjungan");
$id_tc_soap = baca_tabel('tc_soap', 'id_tc_soap', "where no_kunjungan=$no_kunjungan");
$id_dd_user = baca_tabel('dd_user', 'id_dd_user', "where kode_dokter='$kode_dokter'");

if ($id_tc_status_pasien && $id_tc_soap) {
    unset($editTcStatusPasien);
    $editTcStatusPasien["status_pasien"] = $subjective;
    $editTcStatusPasien["id_dd_user"] = $id_dd_user;
    $editTcStatusPasien["tgl_input"] = date('Y-m-d H:i:s');
    $editTcStatusPasien["terapi"] = $analyst;
    $editTcStatusPasien["keterangan"] = $objective;
    $result = update_tabel("tc_status_pasien", $editTcStatusPasien, "where id_tc_status_pasien=$id_tc_status_pasien");

    unset($editTcSoap);
    $editTcSoap["keterangan"] = $objective;
    $editTcSoap["id_dd_user"] = $id_dd_user;
    $editTcSoap["tgl_input"] = date('Y-m-d H:i:s');

    if($result) {
        $result = update_tabel("tc_soap", $editTcSoap, "WHERE id_tc_soap=$id_tc_soap");
    }

    //=========================		DETELE ICD-10 	===================================//
    // if($result) {
    //     $result = delete_tabel("th_riwayat_pasien", "where no_mr='$no_mr' AND no_registrasi=$no_registrasi AND no_kunjungan=$no_kunjungan");
    // }
    // if($result) {
    //     $result = delete_tabel("th_icd10_pasien", "WHERE no_mr='$no_mr' AND no_registrasi=$no_registrasi");
    // }
    //=========================		END 	===================================//

} else {
    unset($insertTcStatusPasien);
    $insertTcStatusPasien["no_mr"] = $no_mr;
    $insertTcStatusPasien["no_registrasi"] = $no_registrasi;
    $insertTcStatusPasien["no_kunjungan"] = $no_kunjungan;
    $insertTcStatusPasien["status_pasien"] = $subjective;
    $insertTcStatusPasien["id_dd_user"] = $id_dd_user;
    $insertTcStatusPasien["tgl_input"] = date('Y-m-d H:i:s');
    $insertTcStatusPasien["terapi"] = $analyst;
    $insertTcStatusPasien["keterangan"] = $objective;
    $insertTcStatusPasien["instruksi"] = $instruksi;
    $result = insert_tabel("tc_status_pasien", $insertTcStatusPasien);

    $id_tc_status_pasien=baca_tabel('tc_status_pasien', 'id_tc_status_pasien', "where no_kunjungan=$no_kunjungan");

    unset($insertTcSoap);
    $insertTcSoap["keterangan"] = $objective;
    $insertTcSoap["no_kunjungan"] = $no_kunjungan;
    $insertTcSoap["no_registrasi"] = $no_registrasi;
    $insertTcSoap["no_mr"] = $no_mr;
    $insertTcSoap["id_dd_user"] = $id_dd_user;
    $insertTcSoap["tgl_input"] = date('Y-m-d H:i:s');
    $insertTcSoap["kode_dokter"] = $kode_dokter;
    if($result) {
        $result = insert_tabel("tc_soap", $insertTcSoap);
    }
}

if($result) {
    if ($id_tc_status_pasien && $id_tc_soap){

        $data['code']=200;
        $data['msg']='SOAP berhasil diedit';
    } else {
        $data['code']=200;
        $data['msg']='SOAP berhasil ditambahkan';

    }
} else {
    $data['code']=500;
    $data['msg']='Maaf, SOAP gagal ditambahkan';
}

echo json_encode($data);
