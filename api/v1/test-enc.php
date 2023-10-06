<?php

include "../src/export.php";

$dataSend = file_get_contents("php://input");
$json = json_decode($dataSend, true);
$json1 = json_encode($json);
$enkrip = base64_encode($json1);
$dekrip = enkrip($enkrip);
echo $dekrip;