<?php
include "cek-token.php";

// username

$cek = baca_tabel('user', 'count(username)', "where username='$username'");

if (!$username || $username == '' || $cek == 0) {
	$datax['code'] = 404;
	$datax['msg'] = "Data Tidak Ditemukan";
	echo encryptData($datax);
	die();
}

$sql = "SELECT a.id, a.nama, a.email, b.nama_roles, 
c.nama_provinsi as provinsi, d.nama_kota as kota, 
e.nama_kecamatan as kecamatan, f.nama_kelurahan as kelurahan,
g.title as title_exp, g.caption as caption_exp
from user a 
join roles b on a.id_roles=b.id
join provinsi c on a.id_provinsi=c.id_provinsi
join kota d on a.id_kota=d.id_kota
join kecamatan e on a.id_kecamatan=e.id_kecamatan
join kelurahan f on a.id_kelurahan=f.id_kelurahan
join experience g on a.id=g.id_user
where a.username = '$username' 
order by g.tgl_awal desc limit 1";

$run = $db->Execute($sql);

while ($get = $run->fetchRow()) {
	$id_users = $get['id'];
	unset($get['id']);
	$isEdit = false;
	if ($id_users == $id_user) $isEdit = true;
	$get['is_edit'] = $isEdit;
	$get['foto'] = split(';base64,', $get['foto'])[1];
	$user = $get;
}

if (is_array($user)) {
	$datax['code'] = 200;
	$datax['data'] = $user;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Tidak ada data ditemukan";
}
echo encryptData($datax);
