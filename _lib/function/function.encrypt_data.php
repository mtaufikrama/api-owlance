<?php
function encryptData($jsonencodedata = '')
{
    $enkrip = base64_encode($jsonencodedata);
    $dekrip = enkrip($enkrip);

    return $dekrip;
}

function decryptData()
{
    $dataSend = file_get_contents("php://input");
    $json = dekrip($dataSend);
    $enkrip = base64_decode($json);
    $dekrip = json_decode($enkrip, true);
    return $dekrip;
}
?>