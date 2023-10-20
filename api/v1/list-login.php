<?php

include "cek-token.php";

$Sql = "SELECT device_data, waktu from login where id_user='$id_user' order by waktu desc";

$Run = $db->Execute($Sql);
while ($Tpl = $Run->fetchRow()) {
    $get[] = $Tpl;
}

if (is_array($get)) {
    $data['code'] = 200;
    $data['data'] = $get;
} else {
    $data['code'] = 500;
    $data['msg'] = "data tidak ditemukan";
}
echo encryptData($data);