<?php

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

?>