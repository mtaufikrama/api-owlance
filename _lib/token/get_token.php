<?
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include "../function/db_login.php";
$db->debug=true;
$SqlGetKonf="select kode_rs,email from dd_konfigurasi";
$RunGetKonf=$db->Execute($SqlGetKonf);
while($TplGetKonf=$RunGetKonf->fetchRow()){
	$arrHasil=$TplGetKonf;
}
$postdata = http_build_query(
    $arrHasil
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);
$result = file_get_contents('https://medis.sirs.co.id/src/create_token.php', false, $context);
print_r($result);
$hasil=json_decode($result,true);
$token=$hasil['token']; 
?>