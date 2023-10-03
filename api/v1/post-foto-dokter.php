<?php

include 'cek-token.php';

header('Content-Type: application/x-www-form-urlencoded; charset=utf-8');

$file = $_FILES['foto'];
$kode_dokter = $_POST['kode_dokter'];
// Memeriksa apakah file berhasil diunggah
if ($file['error'] === UPLOAD_ERR_OK) {
    $tempFilePath = $file['tmp_name'];
    echo $tempFilePath;
    // Lakukan operasi lain yang Anda butuhkan dengan file di sini
    // Misalnya, Anda dapat menyimpan file ke direktori tertentu
    $targetDirectory = '_images/foto/foto_dokter/';
    $targetFilePath = $targetDirectory . $file['name'];
    echo $targetFilePath;
    $cek = move_uploaded_file($tempFilePath, $targetFilePath);

    if ($cek) {

        // Mengirim respons sukses
        $response = array(
            'code' => 200,
            'msg' => $targetFilePath
        );
    } else {
        $response = array(
            'code' => 500,
            'msg' => 'Gagal diproses'
        );
    }
    echo json_encode($response);
} else {
    // Mengirim respons gagal
    $response = array(
        'code' => 500,
        'msg' => 'Terjadi kesalahan saat mengunggah file'
    );
    echo json_encode($response);
}
?>