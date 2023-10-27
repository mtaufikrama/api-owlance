<?php

include "cek-no-token.php";

// if ($kode_dokter == '' || $foto == '' || $tgl_akhir == '' || $tgl_mulai == '') {
//     $data['code'] = 500;
//     $data['msg'] = 'Goblok';
//     echo json_encode($data);
//     die;
// }

$size = 0;

foreach ($_FILES as $key => $element) {
    $size = $size + $element['size'];
    if ($size >= 2000000) {
        $datax['code'] = 500;
        $datax['msg'] = 'Data Terlalu Besar';
        echo json_encode($datax);
        die();
    }
    $element['image'] = ("data:" . $get['type'] . ";base64," . base64_encode(file_get_contents($element['tmp_name'])));
    $get[] = $element;
}
$post['size'] = $size;
$post['data'] = $get;

// $path = $foto['tmp_name'];
// $type = $foto['type'];
// $datas = file_get_contents($path);

// $data['kode_dokter'] = $kode_dokter;
// $foto['image'] = ("data:" . $type . ";base64," . base64_encode($datas));
// $data['tgl_mulai'] = $tgl_mulai;
// $data['tgl_akhir'] = $tgl_akhir;

// $result = insert_tabel('tc_sip', $data);

// if ($result) {
//     $data['blob_sip'] = base64_encode($datas);
//     $datax['code'] = 200;
//     $datax['msg'] = $data;
// } else {
//     $datax['code'] = 500;
//     $datax['msg'] = 'Maaf, foto gagal diupload';
// }

echo json_encode($post);
