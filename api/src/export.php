<?php
ini_set('max_execution_time', '0');
include "../../_lib/function/db_login.php";
// include "jwt.php";
include "../encrypt.php";
include "../../_lib/function/function.random_string.php";
include "../../_lib/function/function.encrypt_data.php";
include "../../_lib/function/function.olah_tabel.php";
include "../../_lib/function/function.like_text.php";
// include "../../_lib/function/function.max_kode_number.php";
// include "../../_lib/function/function.angka.php";
// include "../../_lib/function/function.form.php";
// include "../../_lib/function/function.angka_romawi.php";
// include "../../_lib/function/function.datetime.php";
// include "../../_lib/function/function.max_kode_text.php";
// include "../../_lib/function/function.uang.php";
// include "../../_lib/function/function.variabel.php";
// include "../../_lib/function/variabel.php";
// header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Asia/Jakarta');

// Izinkan akses dari domain Anda
header("Access-Control-Allow-Origin: https://owlance.metir.my.id");

// Izinkan metode HTTP yang diperlukan
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Izinkan header yang diperlukan dalam permintaan
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Izinkan pengiriman kredensial (jika diperlukan)
header("Access-Control-Allow-Credentials: true");