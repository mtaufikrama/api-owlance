<?php

include "cek-token.php";

// kode_dokter, nama_pasien, nasabah, id_agama, nama_keluarga, no_hp, no_ktp, id_kerja, tempat_lahir,
// email, tgl_lahir, jenis_kelamin, alamat, id_kawin, id_prov, id_goldar, id_kota, id_kecamatan,
// alergi, kode_pos, id_kelurahan, foto_pasien, no_bpjs, no_polis, id_yankes

$no_induk = baca_tabel('mt_karyawan', 'no_induk', 'where kode_dokter='.$kode_dokter);

$id_dd_user = baca_tabel('dd_user', 'id_dd_user', 'where no_induk='.$no_induk);

$no_registrasi=max_kode_number("tc_registrasi", "no_registrasi");

if($id_nasabah=="2") {

    $no_bpjs="";

} elseif($id_nasabah=="3") {

    $id_yankes="";

    $no_polis="";

} else {

    $no_bpjs="";

    $id_yankes="";

    $no_polis="";

}



$tahun_mr=date("y%");

$no_mr=baca_tabel("mt_master_pasien", "max(no_mr)", "where id_dd_user=$id_dd_user");



if($no_mr!="") {

    $urut=substr($no_mr, 6, 7);

    $urut=$urut+1;

    if($urut < 10) {

        $urut="000000".$urut;

    } elseif($urut < 100) {

        $urut="00000".$urut;

    } elseif($urut < 1000) {

        $urut="0000".$urut;

    } elseif($urut < 10000) {

        $urut="000".$urut;

    } elseif($urut < 100000) {

        $urut="00".$urut;

    } elseif($urut < 1000000) {

        $urut="0".$urut;

    } elseif($urut < 10000000) {

        $urut=$urut;

    }

    $mrID=$id_dd_user.'-'.$urut;



} else {

    $mrID=$id_dd_user.'-'.'0000001';

}



$userDob = $tgl_lahir;

$dob = new DateTime($userDob);

$nDate = new DateTime();

$diff = $nDate->diff($dob);

$umur = $diff->y;



// $rawData = $_POST['foto_residen'];

// list($type, $rawData) = explode(';', $rawData);

// list(, $rawData)      = explode(',', $rawData);

// $unencoded = base64_decode($rawData);

// file_put_contents($alamat.$nama_file_asli, base64_decode($rawData));

// $url_foto_pasien=$alamat.$nama_file_asli;



if(isset($foto_pasien)) {


    /*
    $ArrDat=explode(";",$foto_pasien);
    $ArrDat1=explode("/",$ArrDat[0]);
    $typeFile=$ArrDat1[1];
    $rawData = $_POST['camFoto'];
    list($type, $rawData) = explode(';', $rawData);
    list(, $rawData)      = explode(',', $rawData);
    $alamatimg="../_images/foto/";
    $nama_file_asli=$nama_pasien.date("YmdHis").".".$typeFile;
    file_put_contents($alamatimg.$nama_file_asli, base64_decode($rawData));
    $file=$alamatimg.$nama_file_asli;*/

    $file=$foto_pasien;

} else {

    /*$ArrDat=explode(";",$_POST["foto"]);
    $ArrDat1=explode("/",$ArrDat[0]);
    $typeFile=$ArrDat1[1];
    $rawData = $_POST['foto'];
    list($type, $rawData) = explode(';', $rawData);
    list(, $rawData)      = explode(',', $rawData);
    $alamatimg="../_images/foto/";
    $nama_file_asli=$nama_pasien.date("YmdHis").".".$typeFile;
    file_put_contents($alamatimg.$nama_file_asli, base64_decode($rawData));
    $file=$alamatimg.$nama_file_asli;
    */

    $file=null;
}



$insertPasienBaru["no_mr"]= $mrID;

$insertPasienBaru["nama_pasien"]= $nama_pasien;

$insertPasienBaru["nama_kel_pasien"]= $nama_keluarga;

$insertPasienBaru["no_ktp"]= $no_ktp;

$insertPasienBaru["tempat_lahir"]= $tempat_lahir;

$insertPasienBaru["tgl_lhr"]= $tgl_lahir;

$insertPasienBaru["umur_pasien"]= $umur;

$insertPasienBaru["almt_ttp_pasien"]= $alamat;

$insertPasienBaru["id_dc_propinsi"]= $id_prov;

$insertPasienBaru["id_dc_kota"]= $id_kota;

$insertPasienBaru["id_dc_kecamatan"]= $id_kecamatan;

$insertPasienBaru["id_dc_kelurahan"]= $id_kelurahan;

$insertPasienBaru["kode_pos"]= $kode_pos;

$insertPasienBaru["jen_kelamin"]= $jenis_kelamin;

$insertPasienBaru["status_perkaw"]= $id_kawin;

$insertPasienBaru["gol_darah"]= $id_goldar;

$insertPasienBaru["alergi"]= $alergi;

$insertPasienBaru["kode_agama"]= $id_agama;

$insertPasienBaru["no_hp"]= $no_hp;

$insertPasienBaru["pekerjaan"]= $id_kerja;

$insertPasienBaru["email"]= $email;

//$insertPasienBaru["url_foto_pasien"]= $file;

$insertPasienBaru["kode_perusahaan"]= $id_yankes;
$insertPasienBaru["kode_kelompok"]= $id_nasabah;

$insertPasienBaru["no_askes"]= $no_polis;

$insertPasienBaru["no_bpjs"]= $no_bpjs;
$insertPasienBaru["persetujuan_pasien"]= 1;
$insertPasienBaru["id_dd_user"]= $id_dd_user;

$SqlGetPasien="select count(no_mr) as jml from mt_master_pasien where no_ktp='$no_ktp'";

$RunGetPasien=$db->Execute($SqlGetPasien);

$jml=$RunGetPasien->fields("jml");

if($jml>0) {

    $data['code']=500;
    $data['msg']='Pasien telah terdaftar sebelumnya';

} else {

    $result =insert_tabel("mt_master_pasien", $insertPasienBaru);

    if($result) {

        $data['code']=200;
        $data['msg']='Pasien Baru berhasil ditambahkan';
        $data['pasien']=$insertPasienBaru;
        $data['field']=$fld;

    } else {

        $data['code']=500;
        $data['msg']='Maaf, Data Pasien Baru Gagal ditambahkan';

    }
}



// if($result!==false){

// 	$insertPasienBaru["no_registrasi"]= $no_registrasi;

// 	$insertPasienBaru["no_mr"]= $mrID;

// 	$insertPasienBaru["kode_perusahaan"]= $_POST["pekerjaan"];

// 	$insertPasienBaru["stat_pasien"]= "Baru";

// 	$insertPasienBaru["tgl_jam_masuk"]= date("Y-m-d H:i:s");

// }







// if($result) {

//     //$result=false;



//     // $result =insert_tabel("mt_master_pasien", $insertPasienBaru);


//     /***********************************************************************************************/
//     //INSERT IMAGE KE BASE 64
//     // $cekAda=baca_tabel("mt_master_pasien_img", "no_mr", " where no_mr='".$mrID."'");

//     // if($cekAda!="") {

//     //     unset($fld);
//     //     $fld["foto_pasien"]		= $file;
//     //     if ($result) {
//     //         $result =update_tabel("mt_master_pasien_img", $fld, " where no_mr='".$mrID."'");
//     //     }

//     // } else {
//     //     unset($fld);
//     //     $fld["no_mr"]			= $mrID;
//     //     $fld["foto_pasien"]		= $file;
//     //     if ($result) {
//     //         $result =insert_tabel("mt_master_pasien_img", $fld);
//     //     }
//     // }

//     /***********************************************************************************************/
//     //$result=false;

//     // if($result) {

//     //     $data['code']=200;
//     //     $data['msg']='Pasien Baru berhasil ditambahkan';
//     //     $data['pasien']=$insertPasienBaru;
//     //     $data['field']=$fld;

//     // } else {

//     //     $data['code']=500;
//     //     $data['msg']='Maaf, Data Pasien Baru Gagal ditambahkan';

//     // }

// } else {

//     $data['code']=500;
//     $data['msg']='Pasien sudah terdaftar';

// }

echo json_encode($data);
?>