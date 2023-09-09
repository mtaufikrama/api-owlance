<?php
include "cek-token.php";
require_once("../../_contrib/klinik/api_klinik.php");
$klinik=new klinik();
// $klinik->debug=true;
$hasil=$klinik->GetJadwalDokter($url_site,$src);
// print_r($hasil);
print_r(json_encode($hasil));
?>