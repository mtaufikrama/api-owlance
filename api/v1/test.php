<?php

include '../encrypt.php';

header('Content-Type: application/json');

$dataSend = file_get_contents("php://input");
$dekrip = json_encode(json_decode($dataSend, true));
echo $dekrip;
