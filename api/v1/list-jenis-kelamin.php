<?php
include "cek-token.php";

$data = array(
    array('kode' => '0', 'nama' => '-- Pilih Jenis Kelamin --'),
    array('kode' => '1', 'nama' => 'Tidak Diketahui'),
    array('kode' => '2', 'nama' => 'Laki-Laki'),
    array('kode' => '3', 'nama' => 'Perempuan'),
    array('kode' => '4', 'nama' => 'Tidak Dapat Ditentukan'),
    array('kode' => '5', 'nama' => 'Tidak Mengisi'),
);

if (is_array($data)) {
    $datax['code'] = 200;
    $datax['list'] = $data;
} else {
    $datax['code'] = 500;
    $datax['msg'] = "Tidak ada data ditemukan";
}
echo encryptData($datax);
