<?php

include 'cek-token.php';

$data['code'] = 200;
$data['list'] = [
    [
        'nama' => 'Muawan Asyir',
        'sebagai' => 'CEO Averin',
    ],
    [
        'nama' => 'Muhammad Taufik Ramadhan',
        'sebagai' => 'UX dan Backend Developer',
    ],
    [
        'nama' => 'Irwan Setiawan',
        'sebagai' => 'UI Designer dan UI Developer',
    ],
    [
        'nama' => 'Pudji Risdianto',
        'sebagai' => 'Website Developer',
    ],
    [
        'nama' => 'Kholis Maulana F',
        'sebagai' => 'Website Developer',
    ],
    [
        'nama' => 'Wahiddin',
        'sebagai' => 'API Privy Integration',
    ],
    [
        'nama' => 'Fajar Eri Irianto',
        'sebagai' => 'DevOps',
    ],
    [
        'nama' => 'Anggota CIS',
        'sebagai' => 'RnD',
    ],
];

echo json_encode($data);
