<?php

include "cek-token.php";

//no_ktp, nama_pasien, email, no_hp, tanggal_lahir, tmpt_lhr, alamat, jenis_kelamin, alergi, gol_dar, password
//kelurahan, kota, provinsi, kecamatan, kode_pos

$id_tbl_pasien=max_kode_number("tbl_pasien", "id_tbl_pasien");
$pasien['id_tbl_pasien']=$id_tbl_pasien;

// $username = explode('@', $email)[0];
// $password = $username . '123!';

$pasien['almt_ttp_pasien']=$alamat;
$pasien['tempat_lahir']=$tmpt_lhr;
$pasien['no_ktp']=$no_ktp;
$pasien['jen_kelamin']=$jenis_kelamin;
$pasien['tgl_lhr']=$tanggal_lahir;
$pasien['alergi']=$alergi;
$pasien['golongan_darah']=$golongan_darah;
$pasien['no_hp']=$no_hp;
$pasien['nama_pasien']=$nama_pasien;
$pasien['username']=$username;
$pasien['email']=$email;
$pasien['password']=md5($password);
$pasien['tgl_daftar']=date('Y-m-d');

$cekktp = baca_tabel('tbl_pasien', 'no_ktp', "where no_ktp='$no_ktp'");
$ceknohp = baca_tabel('tbl_pasien', 'no_hp', "where no_hp='$no_hp'");
$cekemail = baca_tabel('tbl_pasien', 'email', "where email='$email'");

if ($cekktp) {
	$ket .= 'NIK';
}
if ($ceknohp) {
	if ($cekktp) {
		$ket .= ', ';
	}
	$ket .= 'No HP';
}
if ($cekemail) {
	if ($cekktp || $ceknohp) {
		$ket .= ', ';
	}
	$ket .= 'Email';
}

if ($ket) {
	echo json_encode(['code'=>500,'msg'=>"$ket sudah digunakan"]);
	die;
}

// if ($kelurahan==''){
//     $data['code']=500;
//     $data['msg']="Goblok";
// 	echo json_encode($data);
// 	die;
// }

$pasien['id_dc_kelurahan']=$kelurahan;
$pasien['id_dc_kota']=$kota;
$pasien['id_dc_propinsi']=$provinsi;
$pasien['id_dc_kecamatan']=$kecamatan;
$pasien['kode_pos']=$kode_pos;

$result=insert_tabel("tbl_pasien", $pasien);

if($result) {
    $data['code']=200;
    $data['msg']="Sukses Mengirimkan data diri";
} else {
    $data['code']=500;
    $data['msg']="Maaf, Pasien gagal registrasi";
}
echo json_encode($data);
?>