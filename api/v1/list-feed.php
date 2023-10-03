<?php
include "cek-token.php";

// username

$id_user = baca_tabel('user','id',"where username='$username'");

$sqlFeed="SELECT a.id, a.caption, a.waktu, c.nama
from feed a 
join followers b on a.id_user=b.id_user 
join user c on b.id_followers=c.id 
join recent d on a.id=d.id_feed and b.id_user=d.id_user
where b.id_user = $id_user 
and d.available is null 
order by a.waktu desc limit 20";

$runFeed=$db->Execute($sqlFeed);

while($getFeed=$runFeed->fetchRow()){;
	$getFeed['id_name'] = 'feed';
	$sqlFeed="SELECT image from feed_img where id='".$getFeed['id']."'";
	$runFeed=$db->Execute($sqlFeed);
	while($getFeed=$runFeed->fetchRow()){;
		$imageFeed[]=$getFeed;
	}
	$getFeed['images'] = $imageFeed;
	unset($imageFeed);
	$feed[]=$getFeed;
}

$sqlGigs="SELECT a.id, a.caption, a.waktu, c.nama
from gigs a 
join history_search b on a.caption like CONCAT('%', b.search, '%')
and d.available is null 
order by a.waktu desc limit 20";

$runGigs=$db->Execute($sqlGigs);

while($getGigs=$runGigs->fetchRow()){;
	$getGigs['id_name'] = 'Gigs';

	$sqlGigsImg="SELECT image from gigs_img where id='".$getGigs['id']."'";
	$runGigsImg=$db->Execute($sqlGigsImg);
	while($getGigsImg=$runGigsImg->fetchRow()){;
		$imageGigs[]=$getGigsImg;
	}
	$getGigs['images'] = $imageGigs;
	unset($imageGigs);
	$Gigs[]=$getGigs;
}

if(is_array($data)){
	$datax['code']=200;
	$datax['kelurahan']=$data;
}else{
	$datax['code']=500;
	$datax['msg']="Tidak ada data ditemukan";
}
echo json_encode($datax);
?>