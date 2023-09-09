<?php
include "cek-token.php";

//id_jadwal_dokter

$delete=delete_tabel('mt_jadwal_dokter','where id_mt_jadwal_dokter=' . $id_jadwal_dokter);

if($delete) {
	$datax['code']=200;
	$datax['msg']='Jadwal Dokter Berhasil Dihapus';
} else {
	$datax['code']=500;
	$datax['msg']="Maaf, Jadwal Dokter Gagal Dihapus";
}

echo json_encode($datax);
?>