<?php

ini_set('max_execution_time', '0');
include "../../_lib/function/db_login.php";

// header("Content-Type: application/x-www-form-urlencoded");

// foreach ($_FILES as $key => $val) {
//     $$key = $val;
// }

echo json_encode($_FILES);
echo json_encode($_POST);
// echo json_encode($_GET);
// echo json_encode(json_decode(file_get_contents("php://input"), true));
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