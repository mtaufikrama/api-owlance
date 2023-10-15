<?php
include "cek-no-token.php";

$sqlFeed = "SELECT a.id
from feed a 
join followers b on a.id_user=b.id_user 
join user c on b.id_followers=c.id 
join recent d on a.id=d.id_feed and b.id_user=d.id_user
where b.id_user = $id_user 
and d.id_feed is null and d.id_user is null 
order by a.waktu desc limit 1";

$runFeed = $db->Execute($sqlFeed);

while ($getFeed = $runFeed->fetchRow()) {
	$getFeed['nama'] = 'feed';
	$data['id_user'] = $id_user;
	$data['id_feed'] = $getFeed['id'];
	$update = insert_tabel('recent', $data);
	unset($data);
	$feed = $getFeed;
}

if (is_array($data)) {
	$datax['code'] = 200;
	$datax = $feed;
} else {
	$datax['code'] = 500;
	$datax['msg'] = "Tidak ada data ditemukan";
}
echo encryptData($datax);
