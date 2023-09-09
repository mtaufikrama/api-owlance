<?php

include "cek-token.php";

$data = array(
    array('kode' => 'Compos Menthis','nama' => 'Compos Menthis'),
    array('kode' => 'Apatis','nama' => 'Apatis'),
    array('kode' => 'Somnolen', 'nama' => 'Somnolen'),
    array('kode' => 'Sopor', 'nama' => 'Sopor'),
    array('kode' => 'Coma','nama' => 'Coma'),
);

if(is_array($data)) {
    $datax['code']	= 200;
    $datax['list']	= $data;
} else {
    $datax['code']	= 500;
    $datax['msg']	= "Tidak ada data ditemukan";
}
echo json_encode($datax);
