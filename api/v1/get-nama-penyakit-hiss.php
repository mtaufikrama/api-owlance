<?php
include 'cek-token.php';
// $db->debug = true;

// src_penyakit

$sql_plus="WHERE (Nama_Penyakit LIKE '%".$src_penyakit."%' or IcdX LIKE '%".$src_penyakit."%')";
$sql = &$db->Execute("SELECT ID1 as kode, Nama_Penyakit as nama FROM mt_penyakit $sql_plus AND ID1 is not null ORDER BY Nama_Penyakit ASC");
while($lp=$sql->fetchRow()){
    $penyakit[] = $lp;
}

if(is_array($penyakit)) {
    $data['code']=200;
    $data['list']=$penyakit;
}else {
    $data['code']=500;
    $data['msg']="Tidak ada data ditemukan";
}
echo json_encode($data);

?>