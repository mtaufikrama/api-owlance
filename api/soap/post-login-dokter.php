<?php

include "cek-token.php";
require_once("../../_contrib/klinik/api_klinik.php");

$klinik=new klinik();
$hasil = $klinik->GetLoginSoap($url_site,$dt_login);
print_r(json_encode($hasil));
?>