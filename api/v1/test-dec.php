<?php

include "../src/export.php";

header('Content-Type: application/json');

// $dataSend = file_get_contents("php://input");
// $json = dekrip($dataSend);
// $enkrip = base64_decode($json);
// $dekrip = json_decode($enkrip, true);
// echo json_encode($dekrip);
echo json_encode(decryptData());
