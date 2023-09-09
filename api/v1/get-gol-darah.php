<?php

include "cek-token.php";

$arr_goldarah = array(
    array(
        'kode' => '',
        'nama' => '-- Pilih Golongan Darah --'
    ),
    array(
        'kode' => 'A',
        'nama' => 'A'
    ),
    array(
        'kode' => 'B',
        'nama' => 'B'
    ),
    array(
        'kode' => 'AB',
        'nama' => 'AB'
    ),
    array(
        'kode' => 'O',
        'nama' => 'O'
    ),
    array(
        'kode' => '---',
        'nama' => 'Belum Diperiksa'
    ),
);

$data['code'] = 200;
$data['list'] = $arr_goldarah;

echo json_encode($data);

?>

