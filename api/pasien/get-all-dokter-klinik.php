<?php

include "cek-token.php";
// loadlib("class","Paging");
// $db->debug=true;

//kode_bagian, provinsi, kota

$getHari=date("N");
$url_rs = "https://a-dokter.id/";
$kode_rs = 'A00001';
// echo $getHari;
switch($getHari) {
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

if ($kode_bagian) {
    $kondisi = "AND b.kode_bagian='$kode_bagian'";
} else {
    $kondisi = "AND b.kode_bagian like '01%'";
}
if ($provinsi) {
    $kondisi .= "AND a.id_dc_propinsi='$provinsi'";
}
if ($kota) {
    $kondisi .= "AND a.id_dc_kota='$kota'";
}

$dokter = "SELECT a.kode_dokter, a.no_induk, a.nama_pegawai, a.kode_bagian, b.nama_bagian, a.url_foto_karyawan as foto 
	from mt_karyawan a 
	join mt_bagian b on a.kode_bagian=b.kode_bagian
	WHERE a.status is null and (a.kode_dokter <> '') and 1=1 $kondisi and b.status_aktif=1 order by nama_pegawai";

$sql_count="SELECT count(no_induk) as jum from ($dokter) as a";
$run_count=$db->Execute($sql_count);
while($tpl_count=$run_count->fetchRow()) {
    $data['count']=$tpl_count['jum'];
}

$i=0;
$getdokter=$db->Execute($dokter);

while ($tampil=$getdokter->FetchRow()) {
    $i++;
    // $ejes=json_encode($tampil);
    // $ejes=base64_encode($ejes);
    $nm_dokter=$tampil['nama_pegawai'];
    $kd_dokter=$tampil['kode_dokter'];
    $kd_bagian=$tampil['kode_bagian'];
    $nm_bagian=$tampil['nama_bagian'];
    $url_rs = "https://a-dokter.id/";
    if ($tampil['foto']) {
        $tampil['foto'] = $url_rs.$tampil['foto'];
    }

    // $foto=base64_encode(file_get_contents("../".$tampil['url_foto_karyawan']));

    if($kd_bagian=='010000') {
        $nm_bagian = "Instalasi";
    }

    $tampil["no"]=$i;

    $sqljadwal = "SELECT id_mt_jadwal_dokter as id, range_hari, jam_mulai, jam_akhir, waktu_periksa from mt_jadwal_dokter where kode_dokter='$kd_dokter' and kode_bagian='$kd_bagian'";

    $runjadwal=$db->Execute($sqljadwal);

    while ($getjadwal=$runjadwal->FetchRow()) {
        $jadwal[] = $getjadwal;
        $tampil['jadwal'] = $jadwal;
    }

    $tgl = date('Y-m-d');

    if ($jadwal) {
        $tampil['msg_dokter'] = "Jadwal Dokter Tersedia";
    } else {
        $tampil['msg_dokter'] = "Jadwal Dokter Tidak Tersedia";
    }

    unset($jadwal);
    $dokters[] = $tampil;

    /*================= 		TR		===================*/

}

$data['code']=200;
$data['items']=$dokters;

echo json_encode($data);
