<?php

include 'cek-token.php';

// kode_dokter
$kode_bagian = baca_tabel('mt_karyawan','kode_bagian','where kode_dokter='.$kode_dokter);
$no_induk = baca_tabel('mt_karyawan','no_induk',"where kode_dokter=$kode_dokter");
$id_dd_user = baca_tabel('dd_user','id_dd_user',"where no_induk=$no_induk");
$tindakan = "where id_dd_user='$id_dd_user'";

$getObat = &$db->Execute("SELECT b.kode_brg as kode, b.nama_brg as nama FROM mt_depo_stok as a INNER JOIN mt_barang as b ON b.kode_brg = a.kode_brg $tindakan");

while($dt=$getObat->fetchRow()) {
    $obat[] = $dt;
}

if(is_array($obat)) {
    $data['code'] = 200;
    $data['list'] = $obat;
} else {
    $data['code'] = 500;
    $data['msg'] = "Data tidak ditemukan";
}

echo json_encode($data);

?>

