<?php
include "cek-no-token.php";

// id, tabs

$cekOtp = baca_tabel($tabs, 'count(*)', "where id='$id'");

if ($cekOtp > 0) {
	$datax['code'] = 200;
	$datax['msg'] = 'Berhasil';
} else {
	$datax['code'] = 404;
	$datax['msg'] = 'Data Tidak Ditemukan';
}

echo encryptData($datax);
