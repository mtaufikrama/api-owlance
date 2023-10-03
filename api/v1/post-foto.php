<?php

include "cek-token.php";

header('Content-Type: application/form-data; charset=utf-8');
//nama gambar
$no_mr = $_POST['no_mr'];
$foto = $_FILES['foto'];
echo $no_mr . $foto['name'];
die;

$fq['nama_gambar'] = $foto['name'];
//ukuran gambar
$fq['ukuran_gambar'] = $foto['size'];

$fq['fileinfo'] = @getimagesize($foto["tmp_name"]);
//lebar gambar
$fq['width'] = $fq['fileinfo'][0];
//tinggi gambar
$fq['height'] = $fq['fileinfo'][1];

//file gambar
$fq['file_gambar'] = addslashes(file_get_contents($foto['tmp_name']));

if ($fq['ukuran_gambar'] > 81920) {
    $data['code'] = 500;
    $data['msg'] = 'Ukuran gambar melebihi 80kb';
} elseif ($fq['width'] > "480" || $fq['height'] > "640") {

    $data['code'] = 500;
    $data['msg'] = 'Ukuran gambar harus 480x640';
} else {
    $we['no_mr'] = $no_mr;
    $we['foto_pasien'] = $fq['file_gambar'];
    $sql = insert_tabel('mt_master_pasien_img', $we);
    if ($sql) {
        $data['code'] = 500;
        $data['msg'] = 'Ukuran gambar harus 480x640';
        echo json_encode($fq);
    } else {
        echo 'Simpan data gagal';
    }
}
?>