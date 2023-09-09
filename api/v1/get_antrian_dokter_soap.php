<?php

include "cek-token.php";
loadlib("class","Paging");
loadlib("function","function.date2str");
// $input = json_decode(file_get_contents('php://input'),true);
// $input = json_decode(file_get_contents('php://input'),TRUE);
// foreach($input as $key=>$val){
// 	$$key=$val;
// }
// $db->debug = true;
// $tanggal = $input['tanggal'];
// $search = $input['search'];
// $kode_dokter = $input['kode_dokter'];
$url_rs = "https://c00001.sirs.co.id";

// if(isset($tanggal)){
//     $TglNow=date("Y-m-d",strtotime($tanggal));
//     $Tgl = date("d",strtotime($tanggal));
//     $Bln = date("m",strtotime($tanggal));
//     $Thn = date("Y",strtotime($tanggal));
// }else{
    // $Tgl=date("d");
    // $Bln=date("m");
    // $Thn=date("Y");
    $Tgl = "16";
    $Bln = "02";
    $Thn = "2023";
// }

if(!empty($search)){
    $sqlpx="AND (mt_master_pasien.nama_pasien like '%$search%' OR tc_registrasi.no_mr like '%$search%' OR mt_master_pasien.almt_ttp_pasien like '%$search%' )";
}

$sql = "SELECT
tc_registrasi.no_mr,
tc_registrasi.flag_bayar,
mt_bagian.nama_bagian,
tc_registrasi.flag_layanan,
tc_registrasi.nomor_antrian,
tc_registrasi.no_registrasi,
tc_registrasi.kode_bagian_masuk,
tc_kunjungan.no_kunjungan,
tc_kunjungan.status_keluar,
tc_kunjungan.kode_bagian_asal,
tc_kunjungan.kode_bagian_tujuan,
pl_tc_poli.tgl_jam_poli,
pl_tc_poli.kode_dokter,
pl_tc_poli.no_antrian,
pl_tc_poli.id_pl_tc_poli,
pl_tc_poli.kode_poli,
pl_tc_poli.kode_bagian as kode_bagian_poli,
mt_master_pasien.nama_pasien,
mt_master_pasien.jen_kelamin,
mt_master_pasien.almt_ttp_pasien,
mt_master_pasien.url_foto_pasien,
mt_master_pasien.gol_darah,
mt_master_pasien.tgl_lhr,
mt_master_pasien.alergi,
mt_master_pasien.no_hp,
mt_dokter_bagian.kode_bagian
FROM
mt_bagian
INNER JOIN pl_tc_poli ON mt_bagian.kode_bagian = pl_tc_poli.kode_bagian
INNER JOIN tc_kunjungan ON pl_tc_poli.no_kunjungan = tc_kunjungan.no_kunjungan
INNER JOIN tc_registrasi ON tc_kunjungan.no_registrasi = tc_registrasi.no_registrasi
INNER JOIN mt_master_pasien ON tc_registrasi.no_mr = mt_master_pasien.no_mr
INNER JOIN mt_dokter_bagian ON tc_registrasi.kode_dokter = mt_dokter_bagian.kode_dokter AND mt_dokter_bagian.kode_bagian=pl_tc_poli.kode_bagian
WHERE YEAR(tgl_jam_poli)='$Thn' AND MONTH(tgl_jam_poli)='$Bln' AND DAY(tgl_jam_poli)='$Tgl' $sqlpx
AND pl_tc_poli.kode_bagian<> '".AV_MCU."' AND tc_registrasi.kode_dokter='$kode_dokter'
AND tc_kunjungan.status_keluar is null  ORDER BY no_antrian";
$cekAntrian = $db->Execute($sql);
while ($da = $cekAntrian->fetchRow()) {

    $kode_bagian_asal = $da['kode_bagian_asal'];
    $kode_bagian_poli = $da['kode_bagian_poli'];
    $tgl_jam_poli	  = $da["tgl_jam_poli"];
    $tgl_lhr          = $da['tgl_lhr'];
    $url_foto_px      = $da['url_foto_pasien'];
    $jekel            = $da['jen_kelamin'];      
    $umur=umur($tgl_lhr);

    $old_date_timestamp = strtotime($tgl_jam_poli);
    $new_date = date('d-m-Y H:i:s', $old_date_timestamp); 
    $new_time = date('H:i:s', $old_date_timestamp); 

    if ($kode_bagian_asal == $kode_bagian_poli){
        $bagian_asal="Registrasi";
    }else{
        $bagian_asal=baca_tabel("mt_bagian","nama_bagian","where kode_bagian='$kode_bagian_asal'");
    }

    if($jekel=="L"){
        $gbr="001-boy.svg";
        $gndr="Laki-laki";
    }else{
        $gbr="003-girl-1.svg";
        $gndr="Perempuan";
    }
    if(file_exists($url_foto_px)){
        $foto_px = $url_rs.$url_foto_px;
    }else{
        $foto_px =	$url_rs."/assets/media/svg/avatars/".$gbr;
    }

    $arr['no_kunjungan']            = $da['no_kunjungan'];
    $arr['no_registrasi']           = $da['no_registrasi'];
    $arr['kode_bagian']             = $da['kode_bagian'];
    $arr['kode_bagian_tujuan']      = $da['kode_bagian_tujuan'];
    $arr['kode_bagian_masuk']       = $da['kode_bagian_masuk'];
    $arr['kode_poli']               = $da['kode_poli'];
    $arr['flag_bayar']              = $da['flag_bayar'];
    $arr['id_pl_tc_poli']           = $da['id_pl_tc_poli'];
    $arr['no_antrian']          = $da['no_antrian'];
    $arr['no_mr']               = $da['no_mr'];
    $arr['nama_px']             = $da['nama_pasien'];
    $arr['gender_px']           = $gndr;
    $arr['url_foto_px']         = $foto_px;
    $arr['umur_px']             = $umur;
    $arr['gol_darah_px']        = $da['gol_darah'];
    $arr['alergi_px']           = $da['alergi'];   
    $arr['jam_daftar']          = $new_date;

    $antrian[] = $arr;
    $data['dt_antrian'] = $antrian;
}

if(is_array($antrian)){
    $data['code']=200;
}else{
    $data['code']=500;
    $data['msg'] = "data tidak ditemukan";
}

echo json_encode($data);

?>