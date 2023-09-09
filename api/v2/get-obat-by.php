<?php
include "cek-token.php";

//search

if ($search != '') {
	$sql_plus="AND (a.nama_brg LIKE '%".$search."%' or  b.kode_brg LIKE '%".$search."%')";
}

$kode_bagian_far = '060101';

$Sql="select a.kode_brg,nama_brg,jml_sat_kcl from mt_barang as a JOIN mt_depo_stok as b ON b.kode_brg = a.kode_brg where kode_kategori like'D%' and b.kode_bagian = '$kode_bagian_far' $sql_plus";

$Run=$db->Execute($Sql);

while($Tpl=$Run->fetchRow()){
	$data[]=$Tpl;
}

if(is_array($data)){
	$datax['code']=200;
	$datax['obat']=$data;
}else{
	$datax['code']=500;
	$datax['msg']="Tidak ada data ditemukan";
}
echo json_encode($datax);
?>