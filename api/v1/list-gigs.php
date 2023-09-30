<?php
include "cek-token.php";

// username

$id_user = baca_tabel('user','id',"where username='$username'");

$sqlFeed="SELECT a.id, a.caption, a.waktu, c.nama
from feed a 
join followers b on a.id_user=b.id_user 
join user c on b.id_followers=c.id 
where b.id_user = $id_user
order by a.waktu desc limit 20";

$runFeed=$db->Execute($sqlFeed);

while($getFeed=$runFeed->fetchRow()){;
	$getFeed['id_name'] = 'feed';
	$feed[]=$getFeed;
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