<?php require_once('../adodb-491/adodb.inc.php'); ?>
<?php
$db->debug=true;
$objConnection = &ADONewConnection('mysql'); 
//print_r($objConnection);
$objConnection->Connect('localhost','root','root','cobain');
?>