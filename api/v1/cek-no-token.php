<?php
include "../src/export.php";
// $db->debug=true;

// $dataSend = json_decode(file_get_contents("php://input"), true);
// foreach ($dataSend as $key => $val) {
// 	$$key = $val;
// }
foreach ($_FILES as $key => $val) {
	$$key = $val;
}
// foreach ($_GET as $key => $val) {
// 	$$key = $val;
// }
foreach ($_POST as $key => $val) {
	$$key = $val;
}