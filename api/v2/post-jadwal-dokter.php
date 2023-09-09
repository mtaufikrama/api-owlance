<?php
include "cek-token.php";

//kode_dokter, id_jadwal_dokter, senin, selasa, rabu, kamis, jumat, sabtu, minggu, jam_awal, jam_akhir, waktu_periksa

$arr_hari = [];
if ($senin == '1') {
	array_push($arr_hari, "Senin");
}
if ($selasa == '1') {
	array_push($arr_hari, "Selasa");
}
if ($rabu == '1') {
	array_push($arr_hari, "Rabu");
}
if ($kamis == '1') {
	array_push($arr_hari, "Kamis");
}
if ($jumat == '1') {
	array_push($arr_hari, "Jumat");
}
if ($sabtu == '1') {
	array_push($arr_hari, "Sabtu");
}
if ($minggu == '1') {
	array_push($arr_hari, "Minggu");
}

$range = implode(',',$arr_hari);

$idkar = baca_tabel("mt_karyawan","id_mt_karyawan","where kode_dokter = $kode_dokter");

$kode_bagian = baca_tabel('mt_dokter_detail','kode_bagian',"where kode_dokter='$kode_dokter'");

$awal = explode(':', $jam_awal);
$akhir = explode(':', $jam_akhir);

unset($mtJadwalDokter);
$mtJadwalDokter["kode_dokter"] = $kode_dokter;
$mtJadwalDokter["kode_bagian"] = $kode_bagian;
$mtJadwalDokter["range_hari"] = $range;
$mtJadwalDokter["jam_mulai"] = date("Y-m-d")." ".$awal[0].":".$awal[1].":00";
$mtJadwalDokter["jam_akhir"] = date("Y-m-d")." ".$akhir[0].":".$akhir[1].":00";
$mtJadwalDokter["senin"] = $senin;
$mtJadwalDokter["selasa"] = $selasa;
$mtJadwalDokter["rabu"] = $rabu;
$mtJadwalDokter["kamis"] = $kamis;
$mtJadwalDokter["jumat"] = $jumat;
$mtJadwalDokter["sabtu"] = $sabtu;
$mtJadwalDokter["minggu"] = $minggu;
$mtJadwalDokter["id_mt_karyawan"] = $idkar;
$mtJadwalDokter["tgl_input"] = date("Y-m-d H:i:s");
$mtJadwalDokter["waktu_periksa"] = $waktu_periksa;

if ($id_jadwal_dokter == '' || $id_jadwal_dokter == null){
	$result = insert_tabel("mt_jadwal_dokter", $mtJadwalDokter);
} else {
	$result = update_tabel("mt_jadwal_dokter", $mtJadwalDokter, "WHERE id_mt_jadwal_dokter=$id_jadwal_dokter");
}


if($result){
	$data['code']=200;
	$data['msg']='Jadwal Berhasil ditambahkan';
} else {
	$data['code']=500;
	$data['msg']='Maaf, Jadwal Gagal ditambahkan';
}
echo json_encode($data);
?>