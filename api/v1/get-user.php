<?php
include "cek-token.php";

$sql = "SELECT a.username, a.nama, a.email, b.nama_roles, 
c.nama_provinsi as provinsi, d.nama_kota as kota, 
e.nama_kecamatan as kecamatan, f.nama_kelurahan as kelurahan
from user a 
join roles b on a.id_roles=b.id
join provinsi c on a.id_provinsi=c.id_provinsi
join kota d on a.id_kota=d.id_kota
join kecamatan e on a.id_kecamatan=e.id_kecamatan
join kelurahan f on a.id_kelurahan=f.id_kelurahan
where a.id_user = '$id_user'";

$run = $db->Execute($sql);

while ($get = $run->fetchRow()) {
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