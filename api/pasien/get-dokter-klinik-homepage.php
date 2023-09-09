<?php 
include "cek-token.php";
loadlib("class","Paging");
// $db->debug=true;

//================================================================
$limit = '5';
$sqlSearch=" AND a.kode_bagian ='010011'";
//================================================================

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

$sql = "SELECT * FROM mt_karyawan WHERE kode_dokter IS NOT NULL $sqlSearch";

$sql = "SELECT a.kode_dokter,a.kode_bagian,a.id_mt_jadwal_dokter,a.jam_mulai,a.jam_akhir,a.waktu_periksa,b.url_foto_karyawan,b.nama_pegawai,b.no_induk,c.nama_bagian from mt_jadwal_dokter a
join mt_karyawan b on a.kode_dokter=b.kode_dokter
join mt_bagian c on a.kode_bagian=c.kode_bagian
WHERE 1=1 $sqlSearch AND $hari and c.kode_bagian like '01%' and c.status_aktif=1 and c.kode_bagian<>'".AV_MCU."' and c.kode_bagian<>'".AV_HEMODIALISA."' and c.kode_bagian<>'".AV_KEMOTERAPI."' group by b.nama_pegawai";

$sql_count="SELECT count(no_induk) as jum from ($sql) as a";
$run_count=$db->Execute($sql_count);
while($tpl_count=$run_count->fetchRow()){
	$data['count']=$tpl_count['jum'];
}
$recperpage = $limit;
$hal=(0/$limit)+1;
$pagenya = new Paging($db, $sql, $recperpage);
$rsPaging = $pagenya->ExecPage($hal);
$NoAwal = ($hal == "" || $hal < 1) ? 0 : ($rsPaging->_currentPage - 1) * $recperpage;
$i = $pagenya->pagingVars["firstno"];

while ($tampil=$rsPaging->FetchRow()) {
	$i++;
	$ejes=json_encode($tampil);
	$ejes=base64_encode($ejes);
	$nm_dokter=$tampil['nama_pegawai'];
	$kd_dokter=$tampil['kode_dokter'];
	$kd_bagian=$tampil['kode_bagian'];
	$nm_bagian=$tampil['nama_bagian'];
	$id=$tampil['id_mt_jadwal_dokter'];
	$tampil['id']=$id;
	
	$foto=base64_encode(file_get_contents($tampil['url_foto_karyawan']));
	// $foto=$tampil['url_foto_karyawan'];
	$tampil['foto']=$foto;
	if($jen_kelamin=='L'){
		$icon="001-boy.svg";
	}else if($jen_kelamin=='P'){
		$icon="014-girl-7.svg";
	}else{
		$icon="018-girl-9.svg";
	}
	unset($tampil['url_foto_karyawan']);
	unset($tampil['id_mt_jadwal_dokter']);
	if($kd_bagian=='010000'){
		echo "Instalasi";
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