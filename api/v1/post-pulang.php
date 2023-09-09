<?php

include "cek-token.php";

//no_registrasi

$no_kunjungan=baca_tabel('tc_kunjungan', 'no_kunjungan', "where no_registrasi=$no_registrasi");

unset($editTcKunjungan);

$editTcKunjungan["status_keluar"] 		= 1;
$editTcKunjungan["tgl_keluar"] 			= date('Y-m-d H:i:s');

$result = update_tabel("tc_kunjungan", $editTcKunjungan, "WHERE  no_registrasi=$no_registrasi and no_kunjungan=$no_kunjungan");

if ($result) {
    $datax['code']=200;
    $datax['msg']='Pasien berhasil dipulangkan';
} else {
    $datax['code']=500;
    $datax['msg']='Maaf, Pasien gagal dipulangkan';
}
echo json_encode($datax);
?>