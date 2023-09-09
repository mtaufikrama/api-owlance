<?php
include "cek-token.php";
// $db->debug=true;
// print_r($dataSend);

$GetDokter=$db->Execute("select a.kode_dokter,nama_bagian,nama_pegawai from mt_dokter_bagian as a join mt_bagian as b on a.kode_bagian=b.kode_bagian join mt_karyawan as c on a.kode_dokter=c.kode_dokter where a.kode_bagian like'04%';");
$dktr = $GetDokter->Fields('kode_dokter');
if($dktr!=""){
	while($dr=$GetDokter->fetchRow()){
		
        $dt_dr['kode_dokter']=$dr['kode_dokter'];
		$dt_dr['nama_dokter']=$dr['nama_pegawai'];
	
        $data['code']=200;
        $data['list'][]=$dt_dr;
    }
}else{
	$data['code']=500;
	$data['msg']="data tidak ditemukan";
}

echo json_encode($data);
?>