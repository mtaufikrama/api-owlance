<?php

include "cek-token.php";

// username, password

$pass = enkrip($password);

$SqlGetAksesPx = "SELECT id_dd_user, id_dd_user_group, no_induk from dd_user where username = '$username' AND password = '$pass';";

$RunGetAksesPx = $db->Execute($SqlGetAksesPx);
while ($TplGetAksesPx = $RunGetAksesPx->fetchRow()) {
    $kelompok = $TplGetAksesPx['id_dd_user_group'];
    $no_induk = $TplGetAksesPx['no_induk'];
    $no_induk_dokter = baca_tabel('mt_karyawan', 'no_induk_dokter', "where no_induk='$no_induk' and email='$username'");
    $flag = baca_tabel('mt_karyawan', 'flag_dokter', "where no_induk='$no_induk' and email='$username'");

    if ($kelompok == '1215' || $flag == '2') {
        $dl['kode_kelompok'] = 2;
        $dl['nama_kelompok'] = 'Dosen';
        $dl['kode'] = $no_induk_dokter;
    } elseif ($kelompok == '1216' || $flag == '3') {
        $dl['kode_kelompok'] = 3;
        $dl['nama_kelompok'] = 'Mahasiswa';
        $dl['kode'] = $no_induk_dokter;
    } else {
        $kode_dokter = baca_tabel('mt_karyawan', 'kode_dokter', "where no_induk='$no_induk'");
        $dl['kode_kelompok'] = 1;
        $dl['nama_kelompok'] = 'Dokter';
        $dl['kode'] = $kode_dokter;
    }
    $arrData = $dl;
}

if (is_array($arrData)) {
    //$kunci=getEncData($arrData);
    $dataRes['code'] = 200;
    $dataRes['res'] = $arrData;
    echo json_encode($dataRes);
} else {
    $dataRes['code'] = 300;
    $dataRes['msg'] = 'Maaf tidak ditemukan data pasien dengan data login anda';
    echo json_encode($dataRes);
}