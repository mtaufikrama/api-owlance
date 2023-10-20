<?php
include "cek-token.php";

// id

if (!$id || $id == '') {
    $datax['code'] = 500;
    $datax['msg'] = 'Terjadi Kesalahan, Coba Resend Code Kembali';
}

delete_tabel('otp', "where id='$id'");

$otp = randomOtp();

$dataOtp['id_user'] = $id;
$dataOtp['otp'] = $otp;
$dataOtp['waktu'] = date('Y-m-d H:i:s');
$result = insert_tabel('otp', $dataOtp);
if ($result) {
    $datax['code'] = 200;
    $datax['msg'] = 'Masukkan Kode OTP';
} else {
    $datax['code'] = 500;
    $datax['msg'] = 'Terjadi Kesalahan, Coba Resend Code Kembali';
}
echo encryptData($datax);