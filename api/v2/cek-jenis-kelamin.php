<?php

include "cek-token.php";

//jenis_kelamin

if ($jenis_kelamin == '0') {
    $kelamin = '-- Pilih Jenis Kelamin --';
} elseif ($jenis_kelamin == '1') {
    $kelamin = 'Tidak Diketahui';
} elseif ($jenis_kelamin == '2') {
    $kelamin = 'Laki-Laki';
} elseif ($jenis_kelamin == '3') {
    $kelamin = 'Perempuan';
} elseif ($jenis_kelamin == '4') {
    $kelamin = 'Tidak Dapat Ditentukan';
} elseif ($jenis_kelamin == '5') {
    $kelamin = 'Tidak Mengisi';
} else {
    $kelamin = 'Tidak ditentukan';
}

if($kelamin) {
    $data['code']=200;
    $data['msg']=$kelamin;
} else {
    $data['code']=500;
    $data['msg']='Jenis Kelamin Gagal Ditemukan';
}
echo json_encode($data);
?>