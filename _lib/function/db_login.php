<?php
/**
 * db.php : file untuk blah.. blah.. blah..
 * 
 * PHP versions 4 and 5 (Rencana ke depan buat versi 5 doang)
 *
 * @category   mbuh
 * @package    mbuh
 * @author     yoekriz, et al
 * @copyright  2005 yoekriz, et al
 * @license    restricted
 * @version    any idea???
 * @link       http://www.averin-tech.com
 * @see        not yet
 * @since 	   now
 * @todo       belom ada
 * @filesource
 */
if (!defined("AV_LIB_LOADED") || AV_LIB_LOADED==false) {

	// load session
	session_start();	// aktifken kalo udah selesai

	// if session time out throw 'em to login.
	
	if (!defined("DIR_SEPARATOR")) define("DIR_SEPARATOR","\\");

	if (!defined("WWWROOT")) {
		$fname=dirname(__FILE__);
		$wwwroot=substr($fname,0,-14);
		define("WWWROOT",$wwwroot);

		// unset all unused local variables
		unset($wwwroot,$fname);
	}

	// Load configuration & constants
	include WWWROOT."/_configs/constants.php";
	include WWWROOT."/_configs/global.php";
	include WWWROOT."/_lib/_av/function.enkrip.php";
	include WWWROOT."/_lib/purify/HTMLPurifier.auto.php";

	// define development flag constant
	if (isset($AV_CONF["etc"]["development"]) && $AV_CONF["etc"]["development"]) define("DEVELOPMENT",true);

	// initiate database
	if (!isset($db)) {
		require_once "function.dbconn.php";

		$db_type=$AV_CONF["db"]["type"];
		$db_host=$AV_CONF["db"]["host"];
		$db_user=$AV_CONF["db"]["user"];
		$db_pass=dekrip($AV_CONF["db"]["pass"]);
		$db_name=$AV_CONF["db"]["name"];

		if (defined("WWWROOT")) {
			$db=dbconn($db_type,$db_host,$db_user,$db_pass,$db_name);
		} else {
			die("konstanta WWWROOT tidak terdefinisi");
		}
	}

	// security method
	// ...... not implemented yet ......
	if ($AV_CONF["etc"]["development"]==false):
		//include_once 'function.html_enc.php';
	endif; //if ($AV_CONF["etc"]["development"]==false):

	// library-related functions
	include "function.library-related.php";

	// unset all unused local variables
	unset($db_type,$db_host,$db_user,$db_pass,$db_name);

	// define constant to prevent multi-call of db.php
	define("AV_LIB_LOADED",true);

} // end of if (!defined("AV_LIB_LOADED") || AV_LIB_LOADED==false)
foreach($_SERVER as $key=>$conver)
{
	$$key=$conver;
}


//============= Purify XSS ==================//
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);

	if(is_array($_GET)){
		foreach($_GET as $key => $val){
			$valx=$purifier->purify($val);
			
			$$key=$valx;
		}
	}
	if(is_array($_POST)){
		foreach($_POST as $key => $val){
			
			if(!is_array($val)){
				$valx=$purifier->purify($val);
			}else{
				$valx=$val;
			}
			$$key=$valx;
		}
	}
	
	if(is_array($_REQUEST)){
		foreach($_REQUEST as $key => $val){
			
			if(!is_array($val)){
				$valx=$purifier->purify($val);
			}else{
				$valx=$val;
			}
			$$key=$valx;
		}
	}

if (!function_exists("split")) {
	function split($a="",$b=""){
		return explode($a,$b);
	}
}
if($xforce==1){
	$db->debug=true;
}

?>