<?php

include 'cek-token.php';

//alkes, search

if($alkes=='1') {

    // $kode_bagian_far = AV_FARMASI;
    $sql_plus="AND (nama_brg LIKE '%$search%' or  kode_brg LIKE '%$search%')";
    $SqlGetPasien="SELECT kode_brg as kode, nama_brg as nama from mt_barang where  kode_kategori like'E%' $sql_plus;";

} else {

    // $kode_bagian_far = AV_FARMASI;
    $sql_plus="AND (nama_brg LIKE '%$search%' or  kode_brg LIKE '%$search%')";
    $SqlGetPasien="SELECT kode_brg as kode, nama_brg as nama from mt_barang where kode_kategori like'D%' $sql_plus;";

}

$getObat = &$db->Execute($SqlGetPasien);

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

