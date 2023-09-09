<?php

include "cek-token.php";
// $db->debug=true;

//kode_dokter, tgl_daftar

//----------------------------------------------------------------------------------------------//
$TglSkrg=date("Y-m-d");
if(strtotime($tgl_daftar) < strtotime($TglSkrg)) {
    $data['code']=500;
    $data['msg']="Tentukan Jadwal untuk Hari ini dan hari setelahnya";
    echo json_encode($data);
    die;
}
//----------------------------------------------------------------------------------------------//

$currTime=date("H:i:s");
$dNow=date("d", strtotime($tgl_daftar));
$mNow=date("m", strtotime($tgl_daftar));
$yNow=date("Y", strtotime($tgl_daftar));


$kode=$kode_dokter;
$pasien=$no_mr;
$no_registrasi=max_kode_number("tc_registrasi", "no_registrasi");


/****************************************************************/

$tanggal = $tgl_daftar;
$day = date('D', strtotime($tanggal));
$dayList = array(
                    'Sun' => 'Minggu',
                    'Mon' => 'Senin',
                    'Tue' => 'Selasa',
                    'Wed' => 'Rabu',
                    'Thu' => 'Kamis',
                    'Fri' => 'Jumat',
                    'Sat' => 'Sabtu'
);

if($day == "Sun") {

    $sqlHari=" and minggu=1";

} elseif($day == "Mon") {

    $sqlHari=" and senin=1";

} elseif($day == "Tue") {

    $sqlHari=" and selasa=1";

} elseif($day == "Wed") {

    $sqlHari=" and rabu=1";

} elseif($day == "Thu") {

    $sqlHari=" and kamis=1";

} elseif($day == "Fri") {

    $sqlHari=" and jumat=1";

} elseif($day == "Sat") {

    $sqlHari=" and sabtu=1";

}
/****************************************************************/


$sqlJadwal = "SELECT * FROM mt_jadwal_dokter WHERE kode_dokter = $kode_dokter $sqlHari";
$hasilJadwal =& $db->Execute($sqlJadwal);

$ambilJadwal = $hasilJadwal->Fields('jam_mulai');
$ambilJadwalAkhir = $hasilJadwal->Fields('jam_akhir');
$ambilDurasi = $hasilJadwal->Fields('waktu_periksa');
if($ambilDurasi < 1) {
    $data['code']=500;
    $data['msg']="Jadwal dokter tidak tersedia";
    echo json_encode($data);
    die;
}
$jam_mulai = date("H:i:s", strtotime($ambilJadwal));
$jam_akhir = date("H:i:s", strtotime($ambilJadwalAkhir));
$jam_sekarang=date("H:i:s");

if (strtotime($jam_sekarang) > strtotime($jam_akhir)) {

    $angka = 0;
    while(strtotime($jam_mulai) < strtotime($jam_akhir)) {
        $angka++;

        $antrianDiambil=baca_tabel("pl_tc_poli", "no_antrian", " where kode_dokter=$kode_dokter
	and no_antrian = $angka and YEAR(tgl_jam_poli)=".$yNow." AND MONTH(tgl_jam_poli)=".$mNow." AND DAY(tgl_jam_poli)=".$dNow."");

        if(strtotime($currTime)<strtotime($jam_mulai)) {
            $jam_mulai = date("H:i:s", strtotime('+ '.$ambilDurasi.' minute', strtotime($jam_mulai)));
        }
    }
}



$angka=$angka;
while(strtotime($jam_mulai) < strtotime($jam_akhir)) {
    $angka++;
    $antrianDiambil=baca_tabel("tc_pendaftaran_klinik", "no_antrian", " where kode_dokter=$kode_dokter
	and no_antrian = $angka and YEAR(tgl_daftar)=".$yNow." AND MONTH(tgl_daftar)=".$mNow." AND DAY(tgl_daftar)=".$dNow." and (flag_status is null or flag_status=99)");
    if($antrianDiambil!=$angka) {
        $antrianDiambil =baca_tabel("pl_tc_poli", "no_antrian", " where kode_dokter=$kode_dokter
	and no_antrian = $angka and YEAR(tgl_jam_poli)=".$yNow." AND MONTH(tgl_jam_poli)=".$mNow." AND DAY(tgl_jam_poli)=".$dNow."");
    }
    //tambahan musa
    if($antrianDiambil < $angka) {
        $tampil['antrian']=$angka;
        $tampil['durasi']=$ambilDurasi;
        $tampil['jam']=date("H:i:s", strtotime($jam_mulai));
        $jam_mulai = date("H:i:s", strtotime('+ '.$ambilDurasi.' minute', strtotime($jam_mulai)));
        if($antrianDiambil==$angka) {
            $data['code']=500;
            $data['msg']="Jadwal dokter tidak tersedia";
        } else {
            $data['list'][]=$tampil;
        }
    } else {
        $jam_mulai = date("H:i:s", strtotime('+ '.$ambilDurasi.' minute', strtotime($jam_mulai)));
    }
}


//----------------------------------------------------------------------------------------------//
if(is_array($data['list'])) {
    $data['code']=200;
} else {
    $data['code']=500;
    $data['msg']="Jadwal dokter tidak tersedia";
}
echo json_encode($data);
