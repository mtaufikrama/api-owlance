<?php

include "cek-token.php";

//id_provinsi 

if ($id_provinsi != "") {
    $SqlGetKota = "SELECT ID_DC_KOTA as kode,NAMA_KOTA as nama from kota where ID_DC_PROPINSI='$id_provinsi'";
} else {
    $data['code'] = 500;
    $data['msg'] = 'ID Provinsi tidak ada';
    echo encryptData($data);
    die;
}

$RunGetKota = $db->Execute($SqlGetKota);
while ($TplGetKota = $RunGetKota->fetchRow()) {
    $json[] = $TplGetKota;
}

if (is_array($json)) {
    $data['code'] = 200;
    $data['list'] = $json;
} else {
    $data['code'] = 500;
    $data['msg'] = "data tidak ditemukan";
}
echo encryptData($data);
