<?php
function randomString($length = 10, $isRandom = true)
{
    if ($isRandom) $length = rand(5, $length);
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $charLength = strlen($characters);

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charLength - 1)];
    }

    return $randomString;
}

function randomOtp()
{
    $length = 4;
    $characters = '0123456789';
    $randomString = '';
    $charLength = strlen($characters);

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charLength - 1)];
    }

    return $randomString;
}

function generateID($length = 10, $tbl = '', $fld = '')
{
    $ulangi = 0;
    $generateString = randomString($length);
    while ($ulangi == 0) {
        $cek = baca_tabel($tbl, $fld, "where $fld = '$generateString'");
        if ($cek) {
            $generateString = randomString($length);
        } else {
            $ulangi = 1;
        }
    }
    return $generateString;
}
