<?php
include "../src/export.php";
// $db->debug=true;

$dataSend = decryptData();
foreach ($dataSend as $key => $val) {
	$$key = $val;
}
foreach ($_FILES as $key => $val) {
	$$key = $val;
}