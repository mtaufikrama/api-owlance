<?php

include "cek-token.php";

$tgl_hadir=date("Y-m-d H:i:s");
$curentTime = date("H:i:s");
$result = true;
$dNow=date("d");
$mNow=date("m");
$yNow=date("Y");

// $db->debug=true;
if($kode_klinik!="C00002"){
    $hasil['code']=500;
    $hasil['msg']="Klinik yang anda kunjungi tidak sesuai dengan daftar antrian yang anda miliki";
    echo json_encode($hasil);
    die;
}
$sql = "select * from tc_pendaftaran_klinik where IdDaftarKlinik='$idRegKlinik'";
$getregist=$db->Execute($sql);
while($isi=$getregist->fetchRow()){

    // $ktpPasien          = $isi['no_ktp'];
    $jam_periksa        = $isi['jam_awal'];
    $nama_klinik        = $isi['nama_klinik'];
    $jam_akhir          = $isi['jam_akhir'];
    $no_antrian         = $isi['no_antrian'];
    $tgl_daftar         = $isi['tgl_daftar'];
    $kode_dokter        = $isi['kode_dokter'];
    $nasabah            = $isi['kode_kelompok'];
    $kode_bag_regist    = $isi['kode_bagian'];
    $nama_poli          = $isi['nama_bagian'];   
    $kode_perusahaan    = $isi['kode_perusahaan'];
    $nama_pasien        = $isi['nama_pasien'];
    $IdDaftarKlinik     = $isi['IdDaftarKlinik'];

}

$sqlfungsidokter = "SELECT * FROM mt_dokter_bagian where kode_dokter = $kode_dokter";
$hasilfungsi =& $db->Execute($sqlfungsidokter);
$fungsi_dokter = $hasilfungsi->Fields('fungsi_dokter');

// if($curentTime > $jam_periksa){

//     $data['code']=500;
//     $data['msg']="Maaf jam periksa anda telah lewat dari jadwal silahkan ke bagian FO untuk melakukan pendaftaran ulang";

// }else{

    $today = date("Y-m-d ").$jam_periksa;
    $interval=($jam_periksa-1)*$durasi;
    $jam_awal = date($today,strtotime('+ '.$interval.' minute',strtotime($jam_periksa)));

    $no_registrasi=max_kode_number("tc_registrasi","no_registrasi");
    $no_kunjungan=max_kode_number("tc_kunjungan","no_kunjungan");
    $kode_poli=max_kode_number("pl_tc_poli","kode_poli");

    $cekRegist = "select no_registrasi,no_mr,tgl_jam_masuk,IdDaftarKlinik from tc_registrasi where IdDaftarKlinik='$IdDaftarKlinik'";
    $runRegist = $db->Execute($cekRegist);
    $dtRegist = $runRegist->Fields('no_registrasi');

    $sql = "select no_mr,nama_pasien,kode_kelompok,kode_perusahaan,tgl_lhr from mt_master_pasien where no_ktp='$no_ktp'";
    $getPX=$db->Execute($sql);
    while($dt_px=$getPX->fetchRow()){
        $no_mr = $dt_px['no_mr'];
        $nama_pasien = $dt_px['nama_pasien'];
        $nasabah = $dt_px['kode_kelompok'];
        $kode_perusahaan = $dt_px['kode_perusahaan'];
        $tgl_lhr = $dt_px['tgl_lhr'];
        $umur_pasien=umur($tgl_lhr);
    }

    if($dtRegist !=""){

        $data['code']=500;
        $data['msg']="Anda sudah terdaftar pada antrian poliklinik dengan data yang sama";
        
    }else if($dtRegist ==""){

        $insertRegis["no_registrasi"]= $no_registrasi;
        $insertRegis["no_mr"]= $no_mr;
        $insertRegis["kode_kelompok"]= $nasabah;
        
//         // if($_POST["nasabah"] == AV_KODE_NASABAH_KARYAWAN){
//         //     $kode_perusahaan=baca_tabel("mt_perusahaan","kode_perusahaan","where nama_perusahaan like '%Karyawan Klinik%'");	
//         // }
        $insertRegis["no_mr"]= $no_mr;
        $insertRegis["kode_perusahaan"]= $kode_perusahaan;
        $insertRegis["kode_dokter"]= $kode_dokter;
        $insertRegis["kode_bagian_masuk"]= $kode_bag_regist;
        $insertRegis["stat_pasien"]= "Lama";
        $insertRegis["umur"]= $umur_pasien;
        $insertRegis["tgl_jam_masuk"]= $jam_awal;
        $insertRegis["flag_layanan"] = $fungsi_dokter;
        $insertRegis["nomor_antrian"]= $no_antrian;
        $insertRegis["IdDaftarKlinik"]= $IdDaftarKlinik;
        $insertRegis["tgl_daftar"]= date("Y-m-d H:i:s");
        // if($nasabah == AV_KODE_NASABAH_BPJS){
        //     $insertRegis["no_askes"]= $_POST["no_bpjs"];
        //     $insertRegis["status_bpjs"]= 1;
        // }

        $result =insert_tabel("tc_registrasi", $insertRegis);

        $insertKunjungan["no_kunjungan"]= $no_kunjungan;
        $insertKunjungan["no_registrasi"]= $no_registrasi;
        $insertKunjungan["no_mr"]= $no_mr;
        $insertKunjungan["kode_dokter"]= $kode_dokter;
        $insertKunjungan["kode_bagian_tujuan"]= $kode_bag_regist;
        $insertKunjungan["kode_bagian_asal"]= $kode_bag_regist;
        $insertKunjungan["tgl_masuk"]= $jam_awal;
        $insertKunjungan["umur_tahun"]= $umur_pasien;
        $insertKunjungan["kunjSakit"]= "1";
        
        if($result) $result =insert_tabel("tc_kunjungan", $insertKunjungan);

        $insertPoli["kode_poli"]= $kode_poli;
        $insertPoli["no_kunjungan"]= $no_kunjungan;
        $insertPoli["kode_bagian"]= $kode_bag_regist;
        $insertPoli["tgl_jam_poli"]= $jam_awal;
        $insertPoli["kode_dokter"]= $kode_dokter;
        $insertPoli["nama_pasien"]= $nama_pasien;
        $insertPoli["flag_layanan"]= $fungsi_dokter;
        $insertPoli["no_antrian"]= $no_antrian;
        
        if($result) $result=insert_tabel("pl_tc_poli", $insertPoli);

//         // unset($updatePasien);
//         // $updatePasien["kode_kelompok"]= $_POST["nasabah"];
        
//         // if($_POST["nasabah"] == AV_KODE_NASABAH_UMUM){
//         //     $updatePasien["kode_perusahaan"]= null;
//         //     $updatePasien["no_askes"]= null;
//         //     $updatePasien["no_bpjs"]= null;
//         // }
//         // if($_POST["nasabah"] == AV_KODE_NASABAH_PERUSAHAAN){
//         //     $updatePasien["kode_perusahaan"]= $_POST["yankes"];
//         //     $updatePasien["no_askes"]= $_POST["no_polis"];
//         // }
//         // if($_POST["nasabah"] == AV_KODE_NASABAH_BPJS){
//         //     $updatePasien["no_bpjs"]= $_POST["no_bpjs"];
//         //     $updatePasien["status_aktif_bpjs"]= $_POST["flag_aktif_bpjs"];
//         // }
//         // if($_POST["nasabah"] == '3'){
//         //     $updatePasien["kode_perusahaan_fktp"]= $_POST["kode_perusahaan_fktp"];
//         // }

        if($IdDaftarKlinik !=""){
            
            $DataJson['no_antrian']=$no_antrian;
            $DataJson['tgl_jam_poli']=$tgl_hadir;
            $DataJson['IdDaftarKlinik']=$IdDaftarKlinik;
            $DataJson['keterangan']=$keterangan;	
            $DataJson['flag_status']=1;	
            $resKlinik=read_tabel("dd_konfigurasi","alamat,telpon");	
            $DataJson['alamat']=$resKlinik->Fields('alamat');
            $DataJson['telpon']=$resKlinik->Fields('telpon');
            unset($upDaf);
            $upDaf['no_antrian_klinik']=$no_antrian;
            $upDaf['no_registrasi']=$no_registrasi;
            $upDaf['tgl_jam_klinik']=$tgl_hadir;
            $upDaf['flag_status']=1;
            // $upDaf['ket_klinik']=$keterangan;
            unset($upDaf['IdDaftarKlinik']);
            $upd_regist=update_tabel("tc_pendaftaran_klinik",$upDaf,"where IdDaftarKlinik='$IdDaftarKlinik'");
            if($upd_regist) {
                include "../_ws_medis/post_konfirmasi_pasien.php";
                if($result){
                    $data['code']=200;
                    $data['msg']="Anda berhasil registrasi pada $nama_poli dengan No antrian $no_antrian pada Jam $jam_awal";
                }else{
                    $data['code']=500;
                    $data['msg']="Invalid Request";
                }
            }
        }
    }
// }
// // $db->CommitTrans($upd_regist!== false);

echo json_encode($data);

?>