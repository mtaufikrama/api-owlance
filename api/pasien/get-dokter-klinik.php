<?php

include "cek-token.php";
require_once ("../../_contrib/klinik/api_klinik.php");

$getHari=date("N");
// echo $getHari;
switch($getHari){
	case 1:
	$hari="senin=1";
	break;
	case 2:
	$hari="selasa=1";
	break;
	case 3:
	$hari="rabu=1";
	break;
	case 4:
	$hari="kamis=1";
	break;
	case 5:
	$hari="jumat=1";
	break;
	case 6:
	$hari="sabtu=1";
	break;
	case 7:
	$hari="minggu=1";
	break;
}

$getdokter = "SELECT kode_dokter,nama_pegawai FROM mt_karyawan WHERE kode_dokter IS NOT NULL AND nama_pegawai LIKE '%".$filter."%'";
$dkt = $db->Execute($getdokter);

while($dt=$dkt->fetchRow()){
	$kd = $dt['kode_dokter'];
	$sql = "select a.kode_dokter,a.id_mt_jadwal_dokter as id,b.nama_pegawai,a.jam_mulai,a.jam_akhir,c.nama_bagian,a.range_hari,b.url_foto_karyawan,b.no_induk,a.waktu_periksa,a.kode_bagian
	from mt_jadwal_dokter a 
	join mt_karyawan b on a.kode_dokter=b.kode_dokter
	join mt_bagian c on a.kode_bagian=c.kode_bagian
	WHERE 1=1 AND a.kode_dokter=$kd and c.kode_bagian like '01%' and c.status_aktif=1 and c.kode_bagian<>'".AV_MCU."' and c.kode_bagian<>'".AV_HEMODIALISA."' and c.kode_bagian<>'".AV_KEMOTERAPI."' order by b.nama_pegawai";
	$qry = $db->Execute($sql);

	// $recperpage = $limit;
	// $hal=($offset/$limit)+1;
	// $pagenya = new Paging($db, $sql, $recperpage);
	// $rsPaging = $pagenya->ExecPage($hal);
	// $NoAwal = ($hal == "" || $hal < 1) ? 0 : ($rsPaging->_currentPage - 1) * $recperpage;
	// $i = $pagenya->pagingVars["firstno"];

	while ($tampil=$qry->fetchRow()) {
		$i++;
		// $ejes=json_encode($tampil);
		// $ejes=base64_encode($ejes);
		$nm_dokter=$tampil['nama_pegawai'];
		$kd_dokter=$tampil['kode_dokter'];
		$kd_bagian=$tampil['kode_bagian'];
		$nm_bagian=$tampil['nama_bagian'];
		// $id=$tampil['id_mt_jadwal_dokter'];
		// $tampil['id']=$id;
		// $url_foto_karyawan=""
		$foto=base64_encode(file_get_contents("../".$tampil['url_foto_karyawan']));
		$tampil['foto']=$foto;
		// if($jen_kelamin=='L'){
		// 	$icon="001-boy.svg";
		// }else if($jen_kelamin=='P'){
		// 	$icon="014-girl-7.svg";
		// }else{
		// 	$icon="018-girl-9.svg";
		// }
		// unset($tampil['url_foto_karyawan']);
		unset($tampil['id_mt_jadwal_dokter']);
		if($kd_bagian=='010000'){
			$nm_bagian= "Instalasi";
		}
		$tampil["no"]=$i;	
		$data['items'][]=$tampil;
		
	}
}
if(is_array($data['items'])){
	$data['code']=200;
}else{
	$data['code']=500;
	$data['msg']="Tidak ada data dokter ditemukan";
}
echo json_encode($data);

?>