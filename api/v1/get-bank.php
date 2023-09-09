<?php

include 'cek-token.php';

$sql = "SELECT id_dd_bank as kode, nama_bank_sink as nama FROM dd_bank";

$run = &$db->Execute($sql);

    while($get=$run->fetchRow()){
        $bank[] = $get;
    }

if(is_array($bank)){
    $data['code'] = 200;
    $data['list'] = $bank;
}else{

    $data['code'] = 500;
    $data['msg'] = "Data tidak ditemukan";
}

echo json_encode($data);

?>

