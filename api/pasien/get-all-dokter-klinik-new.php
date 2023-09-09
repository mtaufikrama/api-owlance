<?php
include "cek-token.php";
require_once ("../../_contrib/klinik/api_klinik.php");
// loadlib("class","Paging");
// $db->debug=true;
$getHari=date("N");
$url_rs = "https://rspluit.sirs.co.id";
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
if($filter != ""){

	$sql = "SELECT a.kode_dokter,a.id_mt_jadwal_dokter as id,b.nama_pegawai,a.jam_mulai,a.jam_akhir,c.nama_bagian,a.range_hari,b.url_foto_karyawan,b.no_induk,a.waktu_periksa,a.kode_bagian
	FROM mt_jadwal_dokter a 
	join mt_karyawan b on a.kode_dokter=b.kode_dokter
	join mt_bagian c on a.kode_bagian=c.kode_bagian
	WHERE 1=1 AND c.kode_bagian=".$filter." AND c.status_aktif=1 and c.kode_bagian<>'".AV_MCU."' and c.kode_bagian<>'".AV_HEMODIALISA."' and c.kode_bagian<>'".AV_KEMOTERAPI."' order by nama_pegawai";

}else{
	
	$sql = "SELECT a.kode_dokter,a.id_mt_jadwal_dokter as id,b.nama_pegawai,a.jam_mulai,a.jam_akhir,c.nama_bagian,a.range_hari,b.url_foto_karyawan,b.no_induk,a.waktu_periksa,a.kode_bagian
	FROM mt_jadwal_dokter a 
	join mt_karyawan b on a.kode_dokter=b.kode_dokter
	join mt_bagian c on a.kode_bagian=c.kode_bagian
	WHERE 1=1 AND c.kode_bagian like '01%' and c.status_aktif=1 and c.kode_bagian<>'".AV_MCU."' and c.kode_bagian<>'".AV_HEMODIALISA."' and c.kode_bagian<>'".AV_KEMOTERAPI."' order by nama_pegawai";

}
$sql_count="SELECT count(no_induk) as jum from ($sql) as a";
$run_count=$db->Execute($sql_count);
while($tpl_count=$run_count->fetchRow()){
	$data['count']=$tpl_count['jum'];
}

$i=0;
$getdokter=$db->Execute($sql);

while ($tampil=$getdokter->FetchRow()) {
	$i++;
	$ejes=json_encode($tampil);
	$ejes=base64_encode($ejes);
	$nm_dokter=$tampil['nama_pegawai'];
	$kd_dokter=$tampil['kode_dokter'];
	$kd_bagian=$tampil['kode_bagian'];
	$nm_bagian=$tampil['nama_bagian'];
	$url_rs = "https://rspluit.sirs.co.id/";
    $foto = $url_rs.$tampil['url_foto_karyawan'];

    // $foto=base64_encode(file_get_contents("../".$tampil['url_foto_karyawan']));
	$tampil['foto']=$foto;

	unset($tampil['url_foto_karyawan']);
	unset($tampil['id_mt_jadwal_dokter']);
	if($kd_bagian=='010000'){
		$nm_bagian = "Instalasi";
	}
	$tampil["no"]=$i;

	/*================= 		TR		===================*/
	if($kd_dokter!=""){
		$data['code']=200;
		$data['items'][]=$tampil;
	}else{
		$data['code']=500;
		$data['msg']="Tidak ada data dokter ditemukan";
	}
}
echo json_encode($data);

?>