<?php
include "cek-token.php";
// include "../encrypt.php";

if ($kode_dokter == '') {
    $data['code'] = 500;
    $data['msg'] = 'Goblok';
    echo json_encode($data);
    die;
}

$images = baca_tabel('tc_sip','blob_sip', "where kode_dokter='$kode_dokter'");

$pos = strpos($images, ';');

$foto['type'] = substr($images, 5, $pos - 5);
$foto['foto'] = explode('base64,', $images)[1];
$foto['mentahan'] = $images;

if ($images) {
    $data['code'] = 200;
    $data['foto'] = $foto;
} else {
    $data['code'] = 500;
    $data['msg'] = 'Maaf, Foto gagal diambil';
}
echo json_encode($data);
?>