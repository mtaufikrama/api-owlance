<?php
ini_set('max_execution_time', '0');
include "../../_lib/function/db_login.php";
include '../../_lib/function/api/input.php';

$uri=$_SERVER['REQUEST_URI'];
if($uri=="/api/bi/get/site"){
	include "get_side.php";
}


?>