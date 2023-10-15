<?php
include "cek-token.php";

// nama, id
switch ($nama) {
	case 'feed':
		$sql = "SELECT a.comment, a.rate, b.username, b.foto 
		from comment a 
		join user b on a.id_user=b.id 
		where id_feed='$id' order by a.waktu desc";
		break;
	case 'gig':
		$sql = "SELECT a.comment, a.rate, b.username, b.foto 
		from comment a 
		join user b on a.id_user=b.id 
		where id_gigs='$id' order by a.waktu desc";
		break;
	case 'project':
		$sql = "SELECT a.comment, a.rate, b.username, b.foto 
		from comment a 
		join user b on a.id_user=b.id 
		where id_gigs='$id' order by a.waktu desc";
		break;
}

$run = $db->Execute($sql);

while ($get = $run->fetchRow()) {
	$data[] = $get;
}

if (is_array($data)) {
	$datax['code'] = 200;
	$datax['lists'] = $data;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Tidak ada data ditemukan";
}
echo encryptData($datax);
