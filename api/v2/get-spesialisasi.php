<?php

include "cek-token.php";

//id

if ($id == '0') {
    $operator = '<>';
    $konjungsi = 'AND';
} else {
    $operator = '=';
    $konjungsi = 'OR';
}

$SqlGetSpesialisasi="SELECT kode_bagian as kode,nama_bagian as nama FROM mt_bagian WHERE kode_bagian LIKE'01%' 
AND group_bag = 'Detail' and (kode_bagian $operator '010001' $konjungsi kode_bagian $operator '010006') ORDER BY nama_bagian";

$RunGetSpesialisasi=$db->Execute($SqlGetSpesialisasi);

while($TplGetSpesialisasi=$RunGetSpesialisasi->fetchRow()) {
    $data[]=$TplGetSpesialisasi;
}

if(is_array($data)) {
    $datax['code']=200;
    $datax['list']=$data;
} else {
    $datax['code']=500;
    $datax['msg']="Tidak ada data ditemukan";
}
echo json_encode($datax);
