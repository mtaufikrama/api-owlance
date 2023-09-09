<?php

include 'cek-token.php';

// kode_dokter

$kode_bagian = baca_tabel('mt_karyawan','kode_bagian','where kode_dokter='.$kode_dokter);
$no_induk = baca_tabel('mt_karyawan','no_induk',"where kode_dokter=$kode_dokter");
$id_dd_user = baca_tabel('dd_user','id_dd_user',"where no_induk=$no_induk");
$tindakan = "and id_dd_user='$id_dd_user'";

$sql = "SELECT kode_tarif as kode, nama_tarif as nama FROM mt_master_tarif where tingkatan=5 $tindakan";

$run = &$db->Execute($sql);

    while($get=$run->fetchRow()){
        $nama_tdk[] = $get;
    }

if(is_array($nama_tdk)){
    $data['code'] = 200;
    $data['list'] = $nama_tdk;
}else{

    $data['code'] = 500;
    $data['msg'] = "Data tidak ditemukan";
}

echo json_encode($data);

?>

