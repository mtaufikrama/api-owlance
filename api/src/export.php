<?php
ini_set('max_execution_time', '300');
include "../../_lib/function/db_login.php";
// include "jwt.php";
// include "../encrypt.php";

include "../../_lib/function/function.random_string.php";
include "../../_lib/function/function.image_link.php";
include "../../_lib/function/function.encrypt_data.php";
include "../../_lib/function/function.olah_tabel.php";
include "../../_lib/function/function.like_text.php";
// include "../../_lib/function/function.max_kode_number.php";
// include "../../_lib/function/function.angka.php";
// include "../../_lib/function/function.form.php";
// include "../../_lib/function/function.angka_romawi.php";
include "../../_lib/function/function.datetime.php";
// include "../../_lib/function/function.max_kode_text.php";
// include "../../_lib/function/function.uang.php";
// include "../../_lib/function/function.variabel.php";
// include "../../_lib/function/variabel.php";
// header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Jakarta');
header("Content-Type: text/plain; charset=utf-8");

// // Izinkan akses dari domain Anda
header("Access-Control-Allow-Origin: https://owlance.metir.my.id, https://web.metlance.com");

// // Izinkan metode HTTP yang diperlukan
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// // Izinkan header yang diperlukan dalam permintaan
// header("Access-Control-Allow-Headers: Content-Type");

// // Izinkan pengiriman kredensial (jika diperlukan)
// header("Access-Control-Allow-Credentials: true");

// // Perlakukan permintaan OPTIONS sebagai permintaan pra-penerbangan dan atur waktu kadaluwarsa cache
// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//     header("Access-Control-Max-Age: 1728000");
//     header("Content-Length: 0");
//     header("Content-Type: text/plain");
// }