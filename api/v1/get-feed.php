<?php
include "cek-no-token.php";

// username

// if ($id_user) {
// 	$cek = baca_tabel(
// 		'feed a 
// 	join followers b on a.id_user=b.id_user 
// 	join user c on b.id_followers=c.id 
// 	join recent d on a.id=d.id_feed and b.id_user=d.id_user
// 	join tabs e on a.id_tabs=e.id',
// 		'count(a.id)',
// 		"where b.id_user = $id_user 
// 	and (d.id_feed is null and d.id_user is null) 
// 	order by a.waktu desc"
// 	);
// 	if ($cek > 0) {
// 		$sql = "SELECT a.id, e.nama from feed a 
// 		join followers b on a.id_user=b.id_user 
// 		join user c on b.id_followers=c.id 
// 		join recent d on a.id=d.id_feed and b.id_user=d.id_user
// 		join tabs e on a.id_tabs=e.id
// 		where b.id_user = $id_user 
// 		and (d.id_feed is null and d.id_user is null) 
// 		order by a.waktu desc limit 7";
// 	} else {
// 		$sql = "SELECT a.id, e.nama
// 		from feed a 
// 		join tabs e on a.id_tabs=e.id
// 		order by a.waktu desc limit 7";
// 	}
// } else {
if ($username || $username != '') {
	$id_users = baca_tabel('user', 'id', "where username='$username'");
	$sql = "SELECT a.id, e.nama as tabs, a.id_user
		from feed a 
		join tabs e on a.id_tabs=e.id
		where a.id_user='$id_users'
		order by a.waktu desc";
} else {
	$sql = "SELECT a.id, e.nama as tabs, a.id_user
		from feed a 
		join tabs e on a.id_tabs=e.id
		order by a.waktu desc limit 7";
}
// }

$run = $db->Execute($sql);

while ($get = $run->fetchRow()) {
	// if ($id_user) {
	// 	$data['id_user'] = $id_user;
	// 	$data['id_feed'] = $get['id'];
	// 	$update = insert_tabel('recent', $data);
	// 	unset($data);
	// }
	$id_users = $get['id_user'];
	unset($get['id_user']);
	$isEdit = false;
	if ($id_users == $id_user) $isEdit = true;
	$get['is_edit'] = $isEdit;
	$feed[] = $get;
}

if (is_array($feed)) {
	$datax['code'] = 200;
	$datax['feed'] = $feed;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Tidak ada data ditemukan";
}
echo encryptData($datax);