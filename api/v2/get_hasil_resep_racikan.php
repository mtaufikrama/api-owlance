<?php

// include "cek-token.php";
require_once("../_lib/function/db_login.php");
loadlib("function","variabel");
loadlib("function","function.olah_tabel");
loadlib("function","function.uang");
// loadlib("class","Paging");
// $db->debug=true;

$input = json_decode(file_get_contents('php://input'),true);
foreach($input as $key => $val ){
    $$key = $val;
}

$qry = &$db->Execute("SELECT a.kode_brg, a.jumlah, a.nilai_pecahan, b.jml_content, c.nama_brg, a.id_tc_far_racikan_detail, a.id_tc_far_racikan, (b.jml_content * a.nilai_pecahan) as jml FROM tc_far_racikan_detail as a INNER JOIN tc_far_racikan as b on a.id_tc_far_racikan=b.id_tc_far_racikan INNER JOIN mt_barang as c ON a.kode_brg = c.kode_brg Where a.id_tc_far_racikan=$id_tc_racikan");
while($dt = $qry->fetchRow()){

    $drc['jumlah']						=$dt["jumlah"];
    // $drc['jml']						    =$dt["jml"];
    // $drc['jml']						    =uang($dt["jml"],true);
    $drc['id_tc_far_racikan_detail']	=$dt['id_tc_far_racikan_detail'];
    $drc['id_far_racikan']			    =$dt['id_tc_far_racikan'];
    $drc['kode_brg']					=$dt['kode_brg'];
    $drc['nama_brg']					=$dt['nama_brg'];
    $drc['komposisi']				    =$dt["nilai_pecahan"];

    $data['isi_racikan'][] = $drc;

}
if(is_array($data['isi_racikan'])){
    $data['code'] = 200;
}else{
    $data['code'] = 500;
    $data['msg'] = "Data tidak ditemukan";
}
echo json_encode($data);
?>


