<?php

include "cek-no-token.php";

// if ($kode_dokter == '' || $foto == '' || $tgl_akhir == '' || $tgl_mulai == '') {
//     $data['code'] = 500;
//     $data['msg'] = 'Goblok';
//     echo json_encode($data);
//     die;
// }
echo json_encode($_FILES);
$path = $foto['tmp_name'];
$type = $foto['type'];
$datas = file_get_contents($path);

// $data['kode_dokter'] = $kode_dokter;
$foto['image'] = ("data:" . $type . ";base64," . base64_encode($datas));
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

echo json_encode($foto);
?>