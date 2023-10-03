<?php

include '../encrypt.php';

$dataSend = file_get_contents("php://input");
$json = json_encode($dataSend);
$enkrip = base64_encode($json);
$dekrip = enkrip($enkrip);
echo $dekrip;
