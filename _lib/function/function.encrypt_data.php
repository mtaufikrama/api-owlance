<?php

function enkrip($txt = "", $mode = 1)
{
    $hasil = "";
    switch ($mode) {
        case 1: // averin encrypt simple				
            $txt = strrev($txt);
            $panjang_str = strlen($txt);
            for ($h = 0; $h < $panjang_str; $h++) {
                $hasil = $hasil . chr(((ord($txt[$h])) + 3));
            }
            break;
        case 2: // averin encrypt with key

            $hasil = md5($txt);
            break;

        case 3:
            $hasil = "";
            break;
    }

    return $hasil;
}


function dekrip($txt = "", $mode = 1)
{
    $hasil = "";
    switch ($mode) {
        case 1:

            $panjang_str = strlen($txt);

            for ($h = 0; $h < $panjang_str; $h++) {
                $hasil = $hasil . chr(((ord($txt[$h])) - 3));
            }
            $hasil = strrev($hasil);

            break;
        case 2:

            $hasil = md5($txt);
            break;

        case 3:
            $hasil = "";
            break;
    }
    return $hasil;
}
function encryptData($data = array())
{
    include WWWROOT . '../../api/encrypt.php';
    $jsonencodedata = json_encode($data);
    $enkrip = base64_encode($jsonencodedata);
    $dekrip = enkrip($enkrip);
    return $dekrip;
}

function decryptData()
{
    include WWWROOT . '../../api/encrypt.php';
    $dataSend = file_get_contents("php://input");
    $json = dekrip($dataSend);
    $enkrip = base64_decode($json);
    $dekrip = json_decode($enkrip, true);
    return $dekrip;
}
