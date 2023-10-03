<?php
require_once("../vendor/autoload.php");
use Ahc\Jwt\JWT;

if (!function_exists('apache_request_headers')) {
	///
	function apache_request_headers()
	{
		$arh = array();
		$rx_http = '/\AHTTP_/';
		foreach ($_SERVER as $key => $val) {
			if (preg_match($rx_http, $key)) {
				$arh_key = preg_replace($rx_http, '', $key);
				$rx_matches = array();
				// do some nasty string manipulations to restore the original letter case
				// this should work in most cases
				$rx_matches = explode('_', $arh_key);
				if (count($rx_matches) > 0 and strlen($arh_key) > 2) {
					foreach ($rx_matches as $ak_key => $ak_val)
						$rx_matches[$ak_key] = ucfirst($ak_val);
					$arh_key = implode('-', $rx_matches);
				}
				$arh[$arh_key] = $val;
			}
		}
		return ($arh);
	}
	///
}
// $headers = apache_request_headers();
// $token = $headers['X-Api-Token'];

// if ($headers['X-Api-Token']){
// 	$q['code'] = 500;
// 	$q['msg'] = 'Aplikasi harus diupdate';
// 	echo json_encode($q);
// 	die;
// }

function getEncData($arr)
{
	$jwt = new JWT('/\\/3RI|\/2020!', 'HS256', 3600, 10);
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
		$url = "https://";
	else
		$url = "http://";

	$url .= $_SERVER['HTTP_HOST'];

	$token = $jwt->encode($arr);

	return $token;
}
function getLoginToken($uid, $uname, $password)
{
	$jwt = new JWT('/\\/3RI|\/2020!', 'HS256', 3600, 10);
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
		$url = "https://";
	else
		$url = "http://";

	$url .= $_SERVER['HTTP_HOST'];

	$token = $jwt->encode([
		'uid' => $uid,
		'uname' => $uname,
		'password' => $password,
		'iss' => $url
	]);

	return $token;
}
function extrakToken($token)
{
	$jwt = new JWT('/\\/3RI|\/2020!', 'HS256', 3600, 10);
	try {
		$payload = $jwt->decode($token);
	} catch (Exception $e) {
		$dataRes['code'] = 500;
		$dataRes['msg'] = $e->getMessage();
		;
		echo json_encode($dataRes);
		die;
		return 0;
	}
	return $payload;
}
function checkValid($token)
{
	$jwt = new JWT('/\\/3RI|\/2020!', 'HS256', 3600, 10);
	$verif = 1;
	try {
		$payload = $jwt->decode($token);
		if ($payload['uname'] != "4dm1n") {
			$verif = 0;
		}
		if ($payload['password'] != "4v3r1n2020!") {
			$verif = 0;
		}

		if ($verif = 1) {
			//echo "Message: Verification successful";
			return 1;
		} else {
			//echo "Message: Verification unsuccessful";
			return 0;
		}
	} catch (Exception $e) {
		echo 'Message: ' . $e->getMessage();
		return 0;
	}
}

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	$base_url = "https://";
else
	$base_url = "http://";

$base_url .= $_SERVER['HTTP_HOST'];
$base_url .= "/";
?>