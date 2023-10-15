<?php
function like_text($word = '', $fld = '')
{

    // Pisahkan string menjadi array kata-kata
    $kata_kunci = explode(' ', $word);

    // Inisialisasi array untuk menyimpan hasil
    $hasil = array();

    // Loop melalui kata-kata dan menghasilkan kombinasi
    for ($i = 0; $i < count($kata_kunci); $i++) {
        $kata = $kata_kunci[$i];
        for ($j = $i; $j < count($kata_kunci); $j++) {
            $hasil[] = implode(' ', array_slice($kata_kunci, $i, $j - $i + 1));
        }
    }

    // Gabungkan hasil menjadi string dengan koma sebagai pemisah
    $q = "($fld like '%" . implode("%' or $fld like '%", $hasil) . "%')";
    // $q = implode(',', $hasil);

    return $q;
}
